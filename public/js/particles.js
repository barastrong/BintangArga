document.addEventListener('DOMContentLoaded', function() {
    const canvas = document.getElementById('particleCanvas');
    const ctx = canvas.getContext('2d');
    
    // Set canvas to full window size
    function resizeCanvas() {
        canvas.width = window.innerWidth;
        canvas.height = window.innerHeight;
    }
    
    // Call resize initially and on window resize
    resizeCanvas();
    window.addEventListener('resize', resizeCanvas);
    
    // Particle settings - using orange/warm colors to match the site theme
    const particleColors = ['#FF9800', '#FFAB40', '#FFD180', '#FFA726', '#FFC107'];
    const particleCount = 70;
    const particleMaxSize = 5;
    const particleMaxSpeed = 0.5;
    const connectionDistance = 150;
    const connectionOpacity = 0.15;
    
    // Particle class
    class Particle {
        constructor() {
            this.x = Math.random() * canvas.width;
            this.y = Math.random() * canvas.height;
            this.size = Math.random() * particleMaxSize + 1;
            this.speedX = (Math.random() - 0.5) * particleMaxSpeed;
            this.speedY = (Math.random() - 0.5) * particleMaxSpeed;
            this.color = particleColors[Math.floor(Math.random() * particleColors.length)];
        }
        
        update() {
            // Update position
            this.x += this.speedX;
            this.y += this.speedY;
            
            // Bounce off edges
            if (this.x < 0 || this.x > canvas.width) {
                this.speedX = -this.speedX;
            }
            
            if (this.y < 0 || this.y > canvas.height) {
                this.speedY = -this.speedY;
            }
        }
        
        draw() {
            ctx.fillStyle = this.color;
            ctx.beginPath();
            ctx.arc(this.x, this.y, this.size, 0, Math.PI * 2);
            ctx.fill();
        }
    }
    
    // Create particles array
    let particles = [];
    function createParticles() {
        particles = [];
        for (let i = 0; i < particleCount; i++) {
            particles.push(new Particle());
        }
    }
    createParticles();
    
    // Draw connections between particles
    function drawConnections() {
        for (let i = 0; i < particles.length; i++) {
            for (let j = i + 1; j < particles.length; j++) {
                const dx = particles[i].x - particles[j].x;
                const dy = particles[i].y - particles[j].y;
                const distance = Math.sqrt(dx * dx + dy * dy);
                
                if (distance < connectionDistance) {
                    // Create gradient for connection
                    const opacity = 1 - (distance / connectionDistance);
                    ctx.strokeStyle = `rgba(255, 152, 0, ${opacity * connectionOpacity})`;
                    ctx.lineWidth = 1;
                    ctx.beginPath();
                    ctx.moveTo(particles[i].x, particles[i].y);
                    ctx.lineTo(particles[j].x, particles[j].y);
                    ctx.stroke();
                }
            }
        }
    }
    
    // Animation loop
    function animate() {
        ctx.fillStyle = 'white';
        ctx.fillRect(0, 0, canvas.width, canvas.height);
        
        // Update and draw each particle
        for (let i = 0; i < particles.length; i++) {
            particles[i].update();
            particles[i].draw();
        }
        
        // Draw connections
        drawConnections();
        
        requestAnimationFrame(animate);
    }
    
    // Start animation
    animate();
    
    // Recreate particles when window is resized
    window.addEventListener('resize', function() {
        resizeCanvas();
        createParticles();
    });
});