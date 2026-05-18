<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bank Sampah Digital - Revolusi Hijau</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        /* Sembunyikan scrollbar agar lebih sinematik */
        ::-webkit-scrollbar { width: 8px; }
        ::-webkit-scrollbar-track { background: #0f172a; }
        ::-webkit-scrollbar-thumb { background: #10b981; border-radius: 4px; }
        
        body { margin: 0; overflow-x: hidden; background-color: #020617; color: white; font-family: 'Inter', sans-serif; }
        #canvas-container { position: fixed; top: 0; left: 0; width: 100vw; height: 100vh; z-index: -1; }
        .glass-panel { background: rgba(15, 23, 42, 0.6); backdrop-filter: blur(12px); border: 1px solid rgba(16, 185, 129, 0.2); }
    </style>
</head>
<body class="antialiased selection:bg-emerald-500 selection:text-white">

    <div id="canvas-container"></div>

    <nav class="fixed w-full z-50 transition-all duration-300 py-4 px-6 md:px-12 glass-panel border-b-0 rounded-b-3xl mt-2 mx-4 max-w-[calc(100%-2rem)]">
        <div class="flex justify-between items-center">
            <div class="flex items-center gap-2">
                <div class="w-8 h-8 rounded-full bg-gradient-to-tr from-emerald-400 to-cyan-400 flex items-center justify-center text-slate-900 font-bold text-xl">♻</div>
                <span class="font-bold text-xl tracking-wide">Bank Sampah<span class="text-emerald-400">Digital</span></span>
            </div>
            <div class="hidden lg:flex gap-6 text-sm text-slate-300 font-medium">
                <a href="#beranda" class="hover:text-emerald-400 transition-colors">Beranda</a>
                <a href="#fitur" class="hover:text-emerald-400 transition-colors">Cara Kerja</a>
                <a href="#keunggulan" class="hover:text-emerald-400 transition-colors">Keunggulan</a>
                <a href="#harga" class="hover:text-emerald-400 transition-colors">Harga</a>
                <a href="#tim" class="hover:text-emerald-400 transition-colors">Tim</a>
            </div>
            <a href="/login" class="bg-gradient-to-r from-emerald-500 to-emerald-400 text-slate-950 px-6 py-2 rounded-full font-bold hover:scale-105 transition-transform shadow-[0_0_15px_rgba(16,185,129,0.5)]">Masuk Portal</a>
        </div>
    </nav>

    <main class="relative z-10">
        
        <section id="beranda" class="min-h-screen flex flex-col justify-center px-6 md:px-20 pt-20 relative">
            <div class="inline-block px-4 py-1.5 rounded-full border border-emerald-500/30 bg-emerald-500/10 text-emerald-400 text-sm font-semibold mb-6 w-max backdrop-blur-md">
                ● Revolusi Digital Bank Sampah
            </div>
            <h1 class="text-5xl md:text-7xl font-extrabold leading-tight mb-6 max-w-3xl">
                Ubah Sampah <br> Menjadi <span class="text-transparent bg-clip-text bg-gradient-to-r from-emerald-400 to-cyan-400">Rupiah & Sembako</span>
            </h1>
            <p class="text-lg md:text-xl text-slate-400 max-w-xl mb-10 leading-relaxed">
                Bergabunglah dengan ribuan warga Purwokerto. Setor sampah, pantau saldo secara real-time, dan tarik dana kapan saja melalui sistem cerdas kami.
            </p>
            <div class="flex gap-4">
                <a href="#fitur" class="bg-emerald-500 text-slate-950 px-8 py-3 rounded-full font-bold hover:bg-emerald-400 transition-colors">Pelajari Caranya</a>
            </div>
        </section>

        <section id="fitur" class="min-h-screen flex items-center px-6 md:px-20 justify-end">
            <div class="max-w-xl text-right md:text-left md:ml-auto">
                <h2 class="text-4xl md:text-5xl font-bold mb-6">Sistem Cerdas,<br>Lingkungan <span class="text-emerald-400">Tuntas</span></h2>
                <div class="space-y-6 mt-10">
                    <div class="glass-panel p-6 rounded-2xl text-left border-l-4 border-l-emerald-400 transform hover:-translate-y-1 transition-transform">
                        <h3 class="text-xl font-bold text-emerald-300 mb-2">1. Request Jemput</h3>
                        <p class="text-slate-400">Tidak perlu repot datang. Cukup tekan tombol, tim armada kami akan meluncur ke lokasi Anda.</p>
                    </div>
                    <div class="glass-panel p-6 rounded-2xl text-left border-l-4 border-l-cyan-400 transform hover:-translate-y-1 transition-transform">
                        <h3 class="text-xl font-bold text-cyan-300 mb-2">2. Timbang & Transparan</h3>
                        <p class="text-slate-400">Penimbangan presisi langsung di tempat. Saldo otomatis masuk ke akun Anda dalam hitungan detik.</p>
                    </div>
                </div>
            </div>
        </section>

        <section id="keunggulan" class="min-h-screen flex flex-col justify-center items-center px-6 md:px-20 relative">
            <div class="text-center mb-12">
                <h2 class="text-4xl md:text-5xl font-bold mb-4">Kenapa <span class="text-emerald-400">Memilih Kami?</span></h2>
                <p class="text-slate-400 max-w-2xl mx-auto">Kami menghadirkan standar baru dalam pengelolaan sampah digital.</p>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 w-full max-w-6xl">
                <div class="glass-panel p-8 rounded-3xl group hover:-translate-y-2 transition-transform duration-300">
                    <div class="text-5xl mb-6">⚡</div>
                    <h3 class="text-xl font-bold text-slate-200 mb-3">Cepat & Responsif</h3>
                    <p class="text-slate-400 text-sm leading-relaxed">Request penjemputan diproses dalam hitungan jam tanpa perlu menunggu jadwal bulanan yang membosankan.</p>
                </div>
                <div class="glass-panel p-8 rounded-3xl group hover:-translate-y-2 transition-transform duration-300 border-t-2 border-t-emerald-400/50">
                    <div class="text-5xl mb-6">🔒</div>
                    <h3 class="text-xl font-bold text-slate-200 mb-3">Aman & Terpercaya</h3>
                    <p class="text-slate-400 text-sm leading-relaxed">Seluruh saldo dan riwayat transaksi tercatat mutasinya secara digital di sistem cloud dengan keamanan tinggi.</p>
                </div>
                <div class="glass-panel p-8 rounded-3xl group hover:-translate-y-2 transition-transform duration-300">
                    <div class="text-5xl mb-6">🌍</div>
                    <h3 class="text-xl font-bold text-slate-200 mb-3">Dampak Nyata</h3>
                    <p class="text-slate-400 text-sm leading-relaxed">Setiap kilogram sampahmu tidak hanya menjadi uang, tapi langsung mencegah penumpukan sampah di wilayah Banyumas.</p>
                </div>
            </div>
        </section>

        <section id="harga" class="min-h-screen flex flex-col justify-center items-center px-6 md:px-20 relative">
            <div class="text-center mb-12">
                <h2 class="text-4xl font-bold mb-4">Live Update <span class="text-emerald-400">Harga Rongsok</span></h2>
                <p class="text-slate-400">Transparansi harga harian tanpa potongan tersembunyi.</p>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 w-full max-w-5xl">
                <div class="glass-panel p-8 rounded-3xl text-center group hover:bg-slate-800/50 transition-colors">
                    <div class="text-4xl mb-4">📦</div>
                    <h3 class="text-slate-300 font-semibold tracking-widest text-sm mb-2">KARDUS / KERTAS</h3>
                    <p class="text-3xl font-bold text-emerald-400">Rp 2.000<span class="text-sm text-slate-500 font-normal">/kg</span></p>
                </div>
                <div class="glass-panel p-8 rounded-3xl text-center group hover:bg-slate-800/50 transition-colors relative overflow-hidden border-b-2 border-b-cyan-400/50">
                    <div class="text-4xl mb-4 relative z-10">⚙️</div>
                    <h3 class="text-slate-300 font-semibold tracking-widest text-sm mb-2 relative z-10">BESI / LOGAM</h3>
                    <p class="text-3xl font-bold text-cyan-400 relative z-10">Rp 5.000<span class="text-sm text-slate-500 font-normal">/kg</span></p>
                </div>
                <div class="glass-panel p-8 rounded-3xl text-center group hover:bg-slate-800/50 transition-colors">
                    <div class="text-4xl mb-4">🥤</div>
                    <h3 class="text-slate-300 font-semibold tracking-widest text-sm mb-2">PLASTIK PET Bening</h3>
                    <p class="text-3xl font-bold text-emerald-400">Rp 2.500<span class="text-sm text-slate-500 font-normal">/kg</span></p>
                </div>
            </div>
        </section>

        <section id="tim" class="min-h-screen flex flex-col justify-center items-center px-6 md:px-20 relative z-10">
            <div class="text-center mb-16">
                <div class="inline-block px-4 py-1 rounded-full border border-emerald-500/30 bg-emerald-500/10 text-emerald-400 text-xs font-bold tracking-widest mb-4">
                    BEHIND THE SCENES
                </div>
                <h2 class="text-4xl md:text-5xl font-bold mb-4">Developed <span class="text-emerald-400">By Team</span></h2>
                <p class="text-slate-400 max-w-2xl mx-auto">Mengenal arsitek di balik sistem revolusi hijau Bank Sampah Digital.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 w-full max-w-6xl">
                <div class="glass-panel p-6 rounded-3xl text-center group hover:-translate-y-2 transition-all duration-300">
                    <div class="w-32 h-32 mx-auto rounded-full bg-slate-800/50 border-2 border-emerald-500/30 mb-6 overflow-hidden flex items-end justify-center group-hover:border-emerald-400 transition-colors relative">
                        <img src="images/fatahulqorib.png" alt="Fatahul Qorib" class="w-full h-full object-cover">
                    </div>
                    <h3 class="text-lg font-bold text-slate-200 mb-1">Fatahul Qorib</h3>
                    <p class="text-emerald-400 text-xs font-semibold tracking-wider">PROJECT LEAD</p>
                </div>

                <div class="glass-panel p-6 rounded-3xl text-center group hover:-translate-y-2 transition-all duration-300">
                    <div class="w-32 h-32 mx-auto rounded-full bg-slate-800/50 border-2 border-cyan-500/30 mb-6 overflow-hidden flex items-end justify-center group-hover:border-cyan-400 transition-colors relative">
                        <img src="images/nizar.png" alt="An Nizar Miftahul Hakin" class="w-full h-full object-cover">
                    </div>
                    <h3 class="text-lg font-bold text-slate-200 mb-1">An Nizar M. Hakin</h3>
                    <p class="text-cyan-400 text-xs font-semibold tracking-wider">DEVELOPER</p>
                </div>

                <div class="glass-panel p-6 rounded-3xl text-center group hover:-translate-y-2 transition-all duration-300">
                    <div class="w-32 h-32 mx-auto rounded-full bg-slate-800/50 border-2 border-emerald-500/30 mb-6 overflow-hidden flex items-end justify-center group-hover:border-emerald-400 transition-colors relative">
                        <img src="images/mei.png" alt="Meiliana Dwi Conita" class="w-full h-full object-cover">
                    </div>
                    <h3 class="text-lg font-bold text-slate-200 mb-1">Meiliana Dwi Conita</h3>
                    <p class="text-emerald-400 text-xs font-semibold tracking-wider">UI/UX DESIGNER</p>
                </div>

                <div class="glass-panel p-6 rounded-3xl text-center group hover:-translate-y-2 transition-all duration-300">
                    <div class="w-32 h-32 mx-auto rounded-full bg-slate-800/50 border-2 border-cyan-500/30 mb-6 overflow-hidden flex items-end justify-center group-hover:border-cyan-400 transition-colors relative">
                        <img src="images/qurotul.png" alt="Qurotul 'Aeni Nur Azmi" class="w-full h-full object-cover">
                    </div>
                    <h3 class="text-lg font-bold text-slate-200 mb-1">Qurotul 'Aeni N. A.</h3>
                    <p class="text-cyan-400 text-xs font-semibold tracking-wider">SYSTEM ANALYST</p>
                </div>
            </div>
        </section>

        <section id="dampak" class="min-h-screen flex flex-col justify-center items-center text-center px-6 md:px-20 relative z-20 bg-gradient-to-t from-[#020617] via-transparent to-transparent">
            <h2 class="text-5xl md:text-7xl font-black mb-6">Masa Depan <br><span class="text-emerald-400">Ada di Tanganmu</span></h2>
            <p class="text-xl text-slate-400 max-w-2xl mb-12">Bergabunglah dengan ratusan warga lainnya, ciptakan Purwokerto yang bersih dan raih keuntungan ekonominya.</p>
            <a href="/register" class="bg-gradient-to-r from-emerald-400 to-cyan-500 text-slate-950 text-xl px-10 py-4 rounded-full font-bold hover:shadow-[0_0_30px_rgba(16,185,129,0.6)] transition-all transform hover:scale-105">Mulai Menabung Sekarang</a>
        </section>

    </main>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/three.js/r128/three.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/ScrollTrigger.min.js"></script>

    <script>
        // SETUP THREE.JS (Sama seperti sebelumnya)
        const container = document.getElementById('canvas-container');
        const scene = new THREE.Scene();
        const camera = new THREE.PerspectiveCamera(75, window.innerWidth / window.innerHeight, 0.1, 1000);
        camera.position.z = 5;

        const renderer = new THREE.WebGLRenderer({ alpha: true, antialias: true });
        renderer.setSize(window.innerWidth, window.innerHeight);
        renderer.setPixelRatio(Math.min(window.devicePixelRatio, 2));
        container.appendChild(renderer.domElement);

        const geometry = new THREE.TorusKnotGeometry(1.2, 0.4, 150, 32);
        const material = new THREE.MeshPhysicalMaterial({
            color: 0x10b981, metalness: 0.2, roughness: 0.1, transmission: 0.9,
            thickness: 1.5, ior: 1.5, clearcoat: 1.0, clearcoatRoughness: 0.1,
            emissive: 0x022c22, emissiveIntensity: 0.5
        });
        const knot = new THREE.Mesh(geometry, material);
        scene.add(knot);

        const isMobile = window.innerWidth < 768;
        if (isMobile) { knot.position.set(0, -2, 0); knot.scale.set(0.8, 0.8, 0.8); } 
        else { knot.position.set(3, 0, 0); }

        const particlesGeometry = new THREE.BufferGeometry();
        const particlesCount = 500;
        const posArray = new Float32Array(particlesCount * 3);
        for(let i = 0; i < particlesCount * 3; i++) { posArray[i] = (Math.random() - 0.5) * 15; }
        particlesGeometry.setAttribute('position', new THREE.BufferAttribute(posArray, 3));
        const particlesMaterial = new THREE.PointsMaterial({ size: 0.02, color: 0x34d399, transparent: true, opacity: 0.5 });
        const particlesMesh = new THREE.Points(particlesGeometry, particlesMaterial);
        scene.add(particlesMesh);

        const ambientLight = new THREE.AmbientLight(0xffffff, 0.5); scene.add(ambientLight);
        const directionalLight = new THREE.DirectionalLight(0xffffff, 1); directionalLight.position.set(2, 2, 2); scene.add(directionalLight);
        const pointLight = new THREE.PointLight(0x22d3ee, 2, 10); pointLight.position.set(-2, -2, 2); scene.add(pointLight);

        const clock = new THREE.Clock();
        function animate() {
            requestAnimationFrame(animate);
            const elapsedTime = clock.getElapsedTime();
            knot.rotation.y = elapsedTime * 0.2; knot.rotation.x = elapsedTime * 0.1;
            particlesMesh.rotation.y = elapsedTime * -0.05;
            renderer.render(scene, camera);
        }
        animate();

        // GSAP SCROLLTRIGGER ANIMATION
        gsap.registerPlugin(ScrollTrigger);

        // Ke Fitur (Kiri)
        gsap.to(knot.position, { x: isMobile ? 0 : -3, y: isMobile ? 0 : 0, ease: "power2.inOut",
            scrollTrigger: { trigger: "#fitur", start: "top bottom", end: "center center", scrub: 1 } });

        // Ke Keunggulan (Tengah & Membesar)
        gsap.to(knot.position, { x: 0, y: 0, ease: "power2.inOut",
            scrollTrigger: { trigger: "#keunggulan", start: "top bottom", end: "center center", scrub: 1 } });
            
        // Ke Harga (Kanan)
        gsap.to(knot.position, { x: isMobile ? 0 : 3, y: isMobile ? 2 : 0, ease: "power2.inOut",
            scrollTrigger: { trigger: "#harga", start: "top bottom", end: "center center", scrub: 1 } });

        // Ke Tim (Kamera Mundur, Objek di Tengah)
        gsap.to(camera.position, { z: 7, ease: "power1.inOut",
            scrollTrigger: { trigger: "#tim", start: "top bottom", end: "center center", scrub: 2 } });
        gsap.to(knot.position, { x: 0, ease: "power2.inOut",
            scrollTrigger: { trigger: "#tim", start: "top bottom", end: "center center", scrub: 1 } });

        // Ke CTA (Terbang)
        gsap.to(knot.position, { y: 5, ease: "power2.in",
            scrollTrigger: { trigger: "#dampak", start: "center center", end: "bottom top", scrub: 1 } });

        window.addEventListener('resize', () => {
            camera.aspect = window.innerWidth / window.innerHeight; camera.updateProjectionMatrix();
            renderer.setSize(window.innerWidth, window.innerHeight);
        });
    </script>
</body>
</html>