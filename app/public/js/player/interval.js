document.addEventListener('DOMContentLoaded', () => {
    const firstNote = document.querySelector('#task .task').dataset.firstNote;
    const secondNote = document.querySelector('#task .task').dataset.secondNote;
    const isHarmonic = document.querySelector('#task .task').dataset.isHarmonic;
    const playButton = document.querySelector('#play-button');

    if (!firstNote || !secondNote || !playButton) {
        return;
    }

    const delay = isHarmonic ? 0 : 1;

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

        piano.triggerAttackRelease(firstNote, '2n', now);
        piano.triggerAttackRelease(secondNote, '2n', now + delay);
    });
})

