document.addEventListener('DOMContentLoaded', () => {
    const firstNote = document.querySelector('#task .task').dataset.firstNote;
    const secondNote = document.querySelector('#task .task').dataset.secondNote;
    const thirdNote = document.querySelector('#task .task').dataset.thirdNote;
    const fourthNote = document.querySelector('#task .task').dataset.fourthNote;
    const isFirstHarmonic = document.querySelector('#task .task').dataset.isFirstHarmonic;
    const isSecondHarmonic = document.querySelector('#task .task').dataset.isSecondHarmonic;
    const playButton = document.querySelector('#play-button');

    if (!firstNote || !secondNote || !playButton || !thirdNote || !fourthNote) {
        return;
    }

    const defaultDelay = isFirstHarmonic ? 2.5 : 1.5;
    const delayFirst = isFirstHarmonic ? 0 : 1;
    const delaySecond = isSecondHarmonic ? 0 : 1;
    const durationFirst = isFirstHarmonic ? '3s' : '2n';
    const durationSecond = isSecondHarmonic ? '3s' : '2n';

    playButton.classList.remove('disabled');
    playButton.removeAttribute('disabled');
    playButton.querySelector('i').classList.add('fadeOut');
    setTimeout(() => {
        playButton.querySelector('i').className = 'bi bi-play-fill';
    }, 500);

    const piano = SampleLibrary.load({
        instruments: "piano",
    })

    piano.toDestination();

    playButton.addEventListener('click', () => {
        if (Tone.context.state !== 'running') {
            Tone.start();
        }

        const now = Tone.now();

        piano.triggerAttackRelease(firstNote, durationFirst, now);
        piano.triggerAttackRelease(thirdNote, durationFirst, now + delayFirst);

        piano.triggerAttackRelease(secondNote, durationSecond, now + defaultDelay + delayFirst);
        piano.triggerAttackRelease(fourthNote, durationSecond, now + defaultDelay + delaySecond + delayFirst);
    });
})

