<html>
<head>
    <title>Nieuwe Lening Aanvragen</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <header class="bg-blue-600 text-white py-4 px-6 text-xl font-semibold">
        Nieuwe Lening Aanvragen
    </header>
    <div class="max-w-2xl mx-auto mt-10 bg-white rounded-lg shadow-lg overflow-hidden">
        <div class="flex justify-around bg-gray-100 py-4">
            <div class="text-center text-blue-600">
                <div class="w-8 h-8 bg-blue-600 text-white rounded-full mx-auto flex items-center justify-center mb-2">1</div>
                <div>Klantgegevens</div>
            </div>
            <div class="text-center text-gray-400">
                <div class="w-8 h-8 bg-gray-300 text-white rounded-full mx-auto flex items-center justify-center mb-2">2</div>
                <div>Leeningsgegevens</div>
            </div>
            <div class="text-center text-gray-400">
                <div class="w-8 h-8 bg-gray-300 text-white rounded-full mx-auto flex items-center justify-center mb-2">3</div>
                <div>Voorwaarden</div>
            </div>
            <div class="text-center text-gray-400">
                <div class="w-8 h-8 bg-gray-300 text-white rounded-full mx-auto flex items-center justify-center mb-2">4</div>
                <div>Bevestiging</div>
            </div>
        </div>
        <div class="p-6">
            <div class="mb-4">
                <label for="name" class="block text-gray-700">Volledige naam</label>
                <input type="text" id="name" placeholder="Voer naam in" class="w-full mt-2 p-2 border border-gray-300 rounded">
            </div>
            <div class="mb-4">
                <label for="email" class="block text-gray-700">E-mailadres</label>
                <input type="email" id="email" placeholder="Voer e-mail in" class="w-full mt-2 p-2 border border-gray-300 rounded">
            </div>
            <div class="mb-4">
                <label for="phone" class="block text-gray-700">Telefoonnummer</label>
                <input type="text" id="phone" placeholder="Voer telefoonnummer in" class="w-full mt-2 p-2 border border-gray-300 rounded">
            </div>
            <div class="mb-4">
                <label for="dob" class="block text-gray-700">Geboortedatum</label>
                <input type="date" id="dob" placeholder="DD-MM-JJJJ" class="w-full mt-2 p-2 border border-gray-300 rounded">
            </div>
            <div class="mb-4">
                <label for="address" class="block text-gray-700">Adres</label>
                <input type="text" id="address" placeholder="Voer volledig adres in" class="w-full mt-2 p-2 border border-gray-300 rounded">
            </div>
        </div>
        <div class="flex justify-end p-6 bg-gray-100">
            <button class="bg-gray-300 text-gray-700 px-4 py-2 rounded mr-2">Terug</button>
            <button class="bg-blue-600 text-white px-4 py-2 rounded">Volgende</button>
        </div>
    </div>
</body>
</html>