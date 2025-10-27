
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload Materials - LMS</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gradient-to-br from-slate-900 via-purple-900 to-slate-900 min-h-screen">
    <!-- Header -->
    <header class="bg-gradient-to-r from-slate-800 to-slate-900 shadow-2xl border-b border-purple-500/20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
            <div class="flex justify-between items-center">
                <div class="flex items-center space-x-3">
                    <i class="fas fa-graduation-cap text-purple-400 text-3xl"></i>
                    <div>
                        <h1 class="text-2xl font-bold text-white">LMS</h1>
                        <p class="text-sm text-purple-300">Hello, <?= esc($user['name']) ?> (<?= ucfirst($user['role']) ?>)</p>
                    </div>
                </div>
                <div class="flex items-center space-x-4">
                    <a href="<?= base_url('dashboard') ?>" class="text-gray-300 hover:text-white px-4 py-2 rounded-lg hover:bg-slate-700 transition-all">
                        <i class="fas fa-home mr-2"></i>Dashboard
                    </a>
                    <a href="<?= base_url('logout') ?>" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg flex items-center space-x-2 transition-all">
                        <i class="fas fa-sign-out-alt"></i><span>Logout</span>
                    </a>
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Page Title -->
        <div class="bg-gradient-to-br from-slate-800 to-slate-900 rounded-2xl shadow-xl p-6 border border-purple-500/20 mb-6">
            <h2 class="text-2xl font-bold text-white mb-2">Upload Course Materials</h2>
            <p class="text-purple-300">Course: <?= esc($course['course_name']) ?> (<?= esc($course['course_code']) ?>)</p>
        </div>

        <!-- Flash Messages -->
        <?php if (session()->getFlashdata('success')): ?>
            <div class="bg-green-500/20 border border-green-500 text-green-300 px-4 py-3 rounded-lg mb-4">
                <i class="fas fa-check-circle mr-2"></i><?= esc(session()->getFlashdata('success')) ?>
            </div>
        <?php endif; ?>

        <?php if (session()->getFlashdata('error')): ?>
            <div class="bg-red-500/20 border border-red-500 text-red-300 px-4 py-3 rounded-lg mb-4">
                <i class="fas fa-exclamation-circle mr-2"></i><?= esc(session()->getFlashdata('error')) ?>
            </div>
        <?php endif; ?>

        <?php if (session()->getFlashdata('errors')): ?>
            <div class="bg-red-500/20 border border-red-500 text-red-300 px-4 py-3 rounded-lg mb-4">
                <ul class="list-disc list-inside">
                    <?php foreach (session()->getFlashdata('errors') as $error): ?>
                        <li><?= esc($error) ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Upload Form -->
            <div class="lg:col-span-1">
                <div class="bg-gradient-to-br from-slate-800 to-slate-900 rounded-2xl shadow-xl p-6 border border-purple-500/20">
                    <h3 class="text-xl font-bold text-white mb-4">Upload New Material</h3>
                    <form action="<?= base_url('materials/upload/' . $course['id']) ?>" method="post" enctype="multipart/form-data">
                        <?= csrf_field() ?>

                        <div class="mb-4">
                            <label class="block text-gray-300 mb-2">Select File</label>
                            <input type="file" name="material_file" required
                                class="w-full px-4 py-3 bg-slate-700 text-white rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:bg-purple-600 file:text-white file:cursor-pointer hover:file:bg-purple-700">
                            <p class="text-sm text-gray-400 mt-2">
                                <i class="fas fa-info-circle mr-1"></i>
                                Max size: 10MB. Allowed: PDF, DOC, DOCX, PPT, PPTX, XLS, XLSX, ZIP, TXT
                            </p>
                        </div>

                        <button type="submit" class="w-full bg-purple-600 hover:bg-purple-700 text-white px-4 py-3 rounded-lg transition-all font-semibold">
                            <i class="fas fa-upload mr-2"></i>Upload Material
                        </button>
                    </form>
                </div>
            </div>

            <!-- Materials List -->
            <div class="lg:col-span-2">
                <div class="bg-gradient-to-br from-slate-800 to-slate-900 rounded-2xl shadow-xl p-6 border border-purple-500/20">
                    <h3 class="text-xl font-bold text-white mb-4">Uploaded Materials</h3>

                    <?php if (empty($materials)): ?>
                        <div class="text-center py-8 text-gray-400">
                            <i class="fas fa-folder-open text-5xl mb-4"></i>
                            <p>No materials uploaded yet</p>
                        </div>
                    <?php else: ?>
                        <div class="space-y-3">
                            <?php foreach ($materials as $material): ?>
                                <div class="bg-slate-700/50 rounded-lg p-4 flex items-center justify-between hover:bg-slate-700 transition-all">
                                    <div class="flex items-center space-x-3 flex-1">
                                        <div class="bg-purple-600 p-3 rounded-lg">
                                            <i class="fas fa-file text-white text-xl"></i>
                                        </div>
                                        <div class="flex-1">
                                            <h4 class="text-white font-semibold"><?= esc($material['file_name']) ?></h4>
                                            <p class="text-sm text-gray-400">
                                                <i class="fas fa-clock mr-1"></i>
                                                <?= date('M d, Y g:i A', strtotime($material['created_at'])) ?>
                                            </p>
                                        </div>
                                    </div>
                                    <div class="flex items-center space-x-2">
                                        <a href="<?= base_url('materials/download/' . $material['id']) ?>" 
                                        class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-2 rounded-lg transition-all">
                                            <i class="fas fa-download"></i>
                                        </a>
                                        <button onclick="confirmDelete(<?= $material['id'] ?>)" 
                                                class="bg-red-600 hover:bg-red-700 text-white px-3 py-2 rounded-lg transition-all">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </main>

    <script>
        function confirmDelete(materialId) {
            if (confirm('Are you sure you want to delete this material? This action cannot be undone.')) {
                window.location.href = '<?= base_url('materials/delete/') ?>' + materialId;
            }
        }
    </script>
</body>
</html>
