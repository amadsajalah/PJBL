<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Tentang Kami - Aryo Sae Gage</title>
  <script src="https://cdn.tailwindcss.com"></script>
    <?php include 'navbar.php'; ?>
  <style>
    @keyframes slide {
      0% { transform: translateX(0); }
      100% { transform: translateX(-50%); }
    }
    .fade-in {
      opacity: 0;
      transform: translateY(30px);
      transition: opacity 1s ease-out, transform 1s ease-out;
    }
    .fade-in.show {
      opacity: 1;
      transform: translateY(0);
    }
  </style>
</head>
<body class="bg-gray-100 text-gray-800 font-sans">


  <!-- Header -->
  <header class="text-center p-8 bg-gradient-to-r from-yellow-400 to-white fade-in">
    <h1 class="text-4xl font-bold mb-2">Tentang Kami</h1>
    <p class="text-lg">
      Kenali lebih dekat siapa kami, apa yang kami lakukan, dan nilai-nilai yang mendorong kami untuk terus melangkah maju.
    </p>
  </header>

  <!-- Carousel Tim -->
  <section class="overflow-hidden w-full py-8 bg-white fade-in">
    <div class="flex gap-4 animate-[slide_15s_linear_infinite] w-max" id="teamCarousel">
      <?php
        $anggota = [
          ['img' => 'images/Amad.png', 'nama' => 'Dhafa Achmad Favian', 'peran' => 'UI/UX Designer'],
          ['img' => 'images/Ais.png', 'nama' => 'Aissya Khayla Muzaqi', 'peran' => 'Proposal Maker'],
          ['img' => 'images/Jojo.png', 'nama' => 'Jonathan Aditiya Pratama', 'peran' => 'Proposal Maker'],
          ['img' => 'images/Andra.png', 'nama' => 'Renandra Ardana', 'peran' => 'Full Stack'],
          ['img' => 'images/Fazle.png', 'nama' => 'Fazle Dzaky Aryaguna', 'peran' => 'Programmer'],
          ['img' => 'images/Reina.png', 'nama' => 'Kireina Thohirutunnida', 'peran' => 'Programmer'],
        ];
        // Duplikat seluruh array untuk looping mulus tanpa jeda
        $anggota = array_merge($anggota, $anggota);
        foreach ($anggota as $a) {
          echo '
          <div class="bg-gradient-to-b from-yellow-400 to-black rounded-xl text-center p-4 min-w-[200px] shadow-md flex-shrink-0">
            <img src="'.$a['img'].'" alt="'.$a['nama'].'" class="w-full h-[220px] object-contain rounded-md">
            <div class="bg-white p-2 rounded mt-2">
              <h3 class="font-bold text-lg">'.$a['nama'].'</h3>
              <p class="text-sm text-gray-400">'.$a['peran'].'</p>
            </div>
          </div>';
        }
      ?>
    </div>
  </section>

 <!-- Kontak Kami -->
<section class="bg-white py-8 px-4 md:px-16 fade-in">
  <div class="md:flex md:items-start md:justify-between gap-8">

    <!-- Biodata -->
    <div class="md:w-2/3 text-center md:text-left">
      <h2 class="text-2xl font-bold mb-2">ARYOSAEGAGE</h2>
      <p><strong>Aryo Sunaryo</strong></p>
      <p>Jalan DepokSari Raya, Tandang, Kec. Tembalang, Kota Semarang, Jawa Tengah</p>
      <p>📞 081329733374</p>
      <p>📷 @rreiinnaa__</p>
    </div>

    <!-- Map Kotak -->
    <div class="md:w-1/3 w-full aspect-square overflow-hidden rounded-lg mt-6 md:mt-0 mx-auto md:mx-0">
      <iframe 
        src="https://www.google.com/maps?q=Tembalang,+Semarang&output=embed" 
        class="w-full h-full border-0"
        allowfullscreen="" loading="lazy">
      </iframe>
    </div>

  </div>
</section>



  
<!-- Quote dan Foto -->
<section class="bg-gray-200 py-8 px-4 md:px-16 fade-in">
  <div class="md:flex md:items-center md:justify-between gap-8">
    
    <!-- Kutipan -->
    <blockquote class="text-2xl md:text-3xl font-semibold italic mb-6 md:mb-0 md:w-2/3 leading-relaxed">
      "Setiap kicauan burung adalah bukti bahwa keindahan bisa menjadi peluang usaha."
    </blockquote>

    <!-- Foto Kelompok Kotak -->
    <div class="w-2/3 md:w-1/4 aspect-square overflow-hidden rounded-lg mx-auto md:mx-0">
      <img 
        src="images/Kelompok.png" 
        alt="Foto Kelompok" 
        class="w-full h-full object-cover"
      >
    </div>

  </div>
</section>




  <!-- Fade-in Script -->
  <script>
    const observer = new IntersectionObserver((entries) => {
      entries.forEach(entry => {
        if (entry.isIntersecting) {
          entry.target.classList.add('show');
        }
      });
    });
    document.querySelectorAll('.fade-in').forEach(el => observer.observe(el));
  </script>

</body>
</html>
