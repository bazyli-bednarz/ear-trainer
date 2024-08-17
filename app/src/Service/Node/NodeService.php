<?php

namespace App\Service\Node;

use App\Dto\Node\NodeWithUserInfoDto;
use App\Dto\Task\TaskWithUserInfoDto;
use App\Entity\Course;
use App\Entity\Node;
use App\Entity\Task\AbstractTask;
use App\Entity\User;
use App\Repository\NodeRepository;
use App\Dto\Node\CreateNodeDto;
use App\Dto\Node\EditNodeDto;
use App\Service\Statistic\TaskStatisticServiceInterface;
use Doctrine\ORM\EntityManagerInterface;

class NodeService implements NodeServiceInterface
{
    public function __construct(
        private readonly NodeRepository         $nodeRepository,
        private readonly EntityManagerInterface $em,
        private readonly TaskStatisticServiceInterface $taskStatisticService,
    )
    {
    }

    public function getFirstNodeForCourse(Course $course): ?Node
    {
        return $this->nodeRepository->findOneBy(['course' => $course, 'previousNode' => null]);
    }


    public function getLastNodeForCourse(Course $course): ?Node
    {
        return $this->nodeRepository->findOneBy(['course' => $course, 'nextNode' => null]);
    }


    public function getNodesForCourse(Course $course): array
    {
        $firstNode = $this->getFirstNodeForCourse($course);
        $nodes = [];
        $currentNode = $firstNode;
        while ($currentNode !== null) {
            $nodes[] = $currentNode;
            $currentNode = $currentNode->getNextNode();
        }

        return $nodes;
    }

    public function getNodesForCourseWithUserInfo(Course $course, User $user): array
    {
        $nodes = $this->getNodesForCourse($course);
        $nodesWithUserInfo = [];

        /** @var Node $node */
        foreach ($nodes as $node) {
            $nodesWithUserInfo[] = new NodeWithUserInfoDto(
                $node->getId(),
                $node->getName(),
                $node->getSlug(),
                $node->getDescription(),
                $this->isNodeCompleted($node, $user),
                $node->getIcon(),
                $this->taskStatisticService->getCompletedTasksCountForNode($node, $user),
                count($node->getTasks())
            );
        }

        return $nodesWithUserInfo;
    }

    public function isNodeCompleted(Node $node, User $user): bool
    {
        $tasks = $node->getTasks();

        if (count($tasks) === 0) {
            return false;
        }

        foreach ($tasks as $task) {
            if (!$this->taskStatisticService->isTaskCompletedByUser($user, $task)) {
                return false;
            }
        }

        return true;
    }

    public function getNodesForCourseExceptGiven(Course $course, Node $node): array
    {
        $firstNode = $this->getFirstNodeForCourse($course);
        $nodes = [];
        $currentNode = $firstNode;
        while ($currentNode !== null) {
            if ($currentNode->getId() !== $node->getId()) {
                $nodes[] = $currentNode;
            }
            $currentNode = $currentNode->getNextNode();
        }

        return $nodes;
    }


    public function create(CreateNodeDto $dto, Course $course): Node
    {
        $node = new Node();

        $previousNode = $dto->getPreviousNode();

        $node
            ->setName($dto->getName())
            ->setDescription($dto->getDescription())
            ->setIcon($dto->getIcon())
            ->setCourse($course);

        $this->em->persist($node);
        $this->em->flush();

        if ($previousNode) {
            $nextNode = $previousNode->getNextNode();
            $nextNode?->setPreviousNode($node);
            $node->setPreviousNode($previousNode);
        } else {
            $firstNode = $this->getFirstNodeForCourse($course);
            if ($firstNode !== $node) {
                $firstNode?->setPreviousNode($node);
            }
        }

        $this->em->flush();

        return $node;
    }

    public function getById(int $id): ?Node
    {
        return $this->nodeRepository->findOneBy(['id' => $id]);
    }

    public function update(Node $node, EditNodeDto $dto): Node
    {
        $previousNode = $dto->getPreviousNode();
        $originalPreviousNode = $node->getPreviousNode();

        $node
            ->setName($dto->getName())
            ->setDescription($dto->getDescription())
            ->setIcon($dto->getIcon());

        if ($originalPreviousNode === $previousNode) {
            $this->em->flush();

            return $node;
        }

        $nodes = $this->getNodesForCourse($node->getCourse());

        $originalNodesOrder = array_map(fn(Node $item) => $item->getId(), $nodes);
        $newNodesOrder = [];
        if (!$previousNode) {
            $newNodesOrder[] = $node->getId();
        }
        foreach ($originalNodesOrder as $key => $value) {
            if ($value === $previousNode?->getId()) {
                $newNodesOrder[] = $value;
                $newNodesOrder[] = $node->getId();
                continue;
            }

            if ($value === $node->getId()) {
                continue;
            }

            $newNodesOrder[] = $value;
        }

        foreach ($nodes as $item) {
            $item->setPreviousNode(null);
            $item->setNextNode(null);
        }

        $this->em->flush();

        foreach ($newNodesOrder as $key => $item) {
            if ($key === 0) {
                continue;
            }
            $prev = $this->nodeRepository->findOneBy(['id' => $newNodesOrder[$key - 1]]);
            $current = $this->nodeRepository->findOneBy(['id' => $item]);

            $current->setPreviousNode($prev);
            $prev->setNextNode($current);
        }

        $this->em->flush();

        return $node;
    }

    public function delete(Node $node): void
    {
        $previousNodeId = $node->getPreviousNode()?->getId();
        $nextNodeId = $node->getNextNode()?->getId();

        $node->setPreviousNode(null);
        $node->getPreviousNode()?->setNextNode(null);
        $node->setNextNode(null);
        $node->getNextNode()?->setPreviousNode(null);

        $this->em->flush();

        $previousNode = $this->nodeRepository->findOneBy(['id' => $previousNodeId]);
        $nextNode =  $this->nodeRepository->findOneBy(['id' => $nextNodeId]);

        $previousNode?->setNextNode($nextNode);
        $nextNode?->setPreviousNode($previousNode);

        $this->em->remove($node);
        $this->em->flush();
    }
}
