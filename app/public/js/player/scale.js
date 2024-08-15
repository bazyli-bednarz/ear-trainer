document.addEventListener('DOMContentLoaded', () => {
    const notes = JSON.parse(document.querySelector('#task .task').dataset.notes)
    const playButton = document.querySelector('#play-button');

    if (!notes || !playButton) {
        return;
    }

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

        notes.forEach(
            (note, index) => {
                const delay = index * 0.5;
                piano.triggerAttackRelease(note, '2n', now + delay);
            }
        );
    });
})

