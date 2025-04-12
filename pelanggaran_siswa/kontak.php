<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hubungi Kami</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gradient-to-r from-indigo-600 to-purple-700 min-h-screen flex items-center justify-center">
    <div class="bg-white p-10 rounded-2xl shadow-2xl max-w-2xl text-center transform transition-all hover:scale-105">
        <h1 class="text-4xl font-extrabold text-indigo-700 mb-4 drop-shadow-lg">Hubungi Kami</h1>
        <p class="text-gray-600 text-lg leading-relaxed mb-6">
            Jika Anda memiliki pertanyaan, masukan, atau memerlukan bantuan, silakan hubungi kami melalui formulir di
            bawah ini atau langsung melalui kontak yang tersedia.
        </p>

        <!-- Formulir Kontak -->
        <form action="proses_kontak.php" method="POST" class="space-y-4">
            <input type="text" name="nama" placeholder="Nama Anda"
                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500"
                required>

            <input type="email" name="email" placeholder="Email Anda"
                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500"
                required>

            <textarea name="pesan" rows="4" placeholder="Pesan Anda"
                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500"
                required></textarea>

            <button type="submit"
                class="w-full px-6 py-3 bg-indigo-600 text-white font-semibold rounded-lg shadow-lg hover:bg-indigo-500 transition duration-300 transform hover:scale-105">
                Kirim Pesan
            </button>
        </form>

        <div class="mt-6 text-gray-600">
            <p>📧 Email: <a href="mailto:admin@sekolah.com"
                    class="text-indigo-600 font-semibold">nafan.ganteng.22@gmail.com</a>
            </p>
            <p>📞 Telepon: <span class="text-indigo-600 font-semibold">+62 819-3441-2604</span></p>
            <p>📍 Alamat: Jl. ince Nurdin, Makassar</p>
        </div>

        <a href="hompage.php"
            class="mt-6 inline-block px-6 py-3 bg-gray-500 text-white font-semibold rounded-lg shadow-lg hover:bg-gray-400 transition duration-300 transform hover:scale-105">
            Kembali ke Beranda
        </a>
    </div>
</body>

</html>