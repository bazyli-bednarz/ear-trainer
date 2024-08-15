document.addEventListener('DOMContentLoaded', () => {
    const firstNote = document.querySelector('#task .task').dataset.firstNote;
    const secondNote = document.querySelector('#task .task').dataset.secondNote;
    const thirdNote = document.querySelector('#task .task').dataset.thirdNote;
    const fourthNote = document.querySelector('#task .task').dataset.fourthNote;

    const isHarmonic = document.querySelector('#task .task').dataset.isHarmonic;
    const playButton = document.querySelector('#play-button');

    if (!firstNote || !secondNote || !playButton || !thirdNote || !fourthNote) {
        return;
    }

    const delay = isHarmonic ? 0 : 1;
    const duration = isHarmonic ? '3s' : '2n';



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

        piano.triggerAttackRelease(firstNote, duration, now);
        piano.triggerAttackRelease(secondNote, duration, now + delay);
        piano.triggerAttackRelease(thirdNote, duration, now + delay * 2);
        piano.triggerAttackRelease(fourthNote, duration, now + delay * 3);
    });
})

