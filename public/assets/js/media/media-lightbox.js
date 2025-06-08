function openMediaModal(src, type = 'image') {
    const modal = document.getElementById('mediaModal');
    const container = document.getElementById('mediaContainer');
    container.innerHTML = '';

    if (type === 'video') {
        const video = document.createElement('video');
        video.src = src;
        video.controls = true;
        video.className = 'max-h-[80vh] max-w-full object-contain aspect-video rounded shadow-lg';
        container.appendChild(video);
    } else {
        const img = document.createElement('img');
        img.src = src;
        img.className = 'max-h-[80vh] max-w-full object-contain rounded shadow-lg';
        container.appendChild(img);
    }

    modal.classList.remove('hidden');
}

function closeMediaModal() {
    const modal = document.getElementById('mediaModal');
    const container = document.getElementById('mediaContainer');
    modal.classList.add('hidden');
    container.innerHTML = '';
}
