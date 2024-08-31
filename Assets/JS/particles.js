
    // Basic Setup
    const scene = new THREE.Scene();
    const camera = new THREE.PerspectiveCamera(75, window.innerWidth / window.innerHeight, 0.1, 1000);
    const renderer = new THREE.WebGLRenderer({ canvas: document.getElementById('background-canvas'), alpha: true });
    renderer.setSize(window.innerWidth, window.innerHeight);

    // Increased Particle Count
    const particleCount = 1500;
    const particles = new THREE.BufferGeometry();
    const particlePositions = new Float32Array(particleCount * 3);

    for (let i = 0; i < particleCount; i++) {
        const x = (Math.random() - 0.5) * 1000;
        const y = (Math.random() - 0.5) * 1000;
        const z = (Math.random() - 0.5) * 1000;
        particlePositions[i * 3] = x;
        particlePositions[i * 3 + 1] = y;
        particlePositions[i * 3 + 2] = z;
    }

    particles.setAttribute('position', new THREE.BufferAttribute(particlePositions, 3));

    // Enhanced 3D Look
    const particleMaterial = new THREE.PointsMaterial({
        color: 0xFFFFFF,
        size: 3, // Increased size for better visibility
        transparent: true,
        opacity: 0.7,
        depthWrite: false, // Ensures particles do not occlude each other
        sizeAttenuation: true, // Makes particles smaller when far away
    });

    const particleSystem = new THREE.Points(particles, particleMaterial);
    scene.add(particleSystem);

    camera.position.z = 400;

    // Smooth Cursor Movement Variables
    let targetX = 0;
    let targetY = 0;
    const easing = 0.05;

    // Animation Loop
    function animate() {
        requestAnimationFrame(animate);
        
        // Apply Smooth Cursor Movement
        const dx = (targetX - particleSystem.rotation.y) * easing;
        const dy = (targetY - particleSystem.rotation.x) * easing;
        
        particleSystem.rotation.y += dx;
        particleSystem.rotation.x += dy;

        // Rotate particle system for continuous movement
        particleSystem.rotation.y += 0.001;

        renderer.render(scene, camera);
    }

    animate();

    // Handle Window Resize
    window.addEventListener('resize', () => {
        const width = window.innerWidth;
        const height = window.innerHeight;
        renderer.setSize(width, height);
        camera.aspect = width / height;
        camera.updateProjectionMatrix();
    });

    // Handle Mouse Movement with Smooth Transition
    document.addEventListener('mousemove', (event) => {
        targetX = (event.clientX / window.innerWidth) * 2 - 1;
        targetY = -(event.clientY / window.innerHeight) * 2 + 1;
    });
