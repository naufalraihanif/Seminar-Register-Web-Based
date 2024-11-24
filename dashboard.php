<?php
session_start();

if (isset($_POST['logout'])) {
    session_destroy();
    header("Location: login.php");
    exit;
}

if (!isset($_SESSION['users'])) {
    $_SESSION['users'] = [];
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && !isset($_POST['logout'])) {
    $npm = $_POST['npm'];
    $nama = $_POST['nama'];
    $prodi = $_POST['prodi'];
    $email = $_POST['email'];

    if (isset($_POST['userId']) && $_POST['userId'] !== '') {
        $id = $_POST['userId'];
        $_SESSION['users'][$id] = ['npm' => $npm, 'nama' => $nama, 'prodi' => $prodi, 'email' => $email];
    } else {
        $_SESSION['users'][] = ['npm' => $npm, 'nama' => $nama, 'prodi' => $prodi, 'email' => $email];
    }
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}

if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    unset($_SESSION['users'][$id]);
    $_SESSION['users'] = array_values($_SESSION['users']);
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Pendaftaran Mahasiswa</title>
    <style>
        body { font-family: Arial, sans-serif; }
        .container { max-width: 800px; margin: auto; padding: 20px; }
        .header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; }
        .header h1 { margin: 0; }
        .button { padding: 8px 16px; background: #007bff; color: white; border: none; cursor: pointer; }
        .button:hover { background: #0056b3; }
        .user-table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        .user-table th, .user-table td { padding: 8px; text-align: left; border: 1px solid #ddd; }
        .form { display: none; flex-direction: column; margin-bottom: 20px; }
        .form input { margin-bottom: 10px; padding: 8px; width: 100%; }
        .form label { margin-bottom: 5px; font-weight: bold; }
    </style>
    <script>
        function showForm(edit = false, index = null, npm = '', nama = '', prodi = '', email = '') {
            document.getElementById('userForm').style.display = 'flex';
            document.getElementById('formTitle').innerText = edit ? 'Edit User' : 'Tambah Mahasiswa';
            document.getElementById('userId').value = index ?? '';
            document.getElementById('npm').value = npm;
            document.getElementById('nama').value = nama;
            document.getElementById('prodi').value = prodi;
            document.getElementById('email').value = email;
        }

        function hideForm() {
            document.getElementById('userForm').style.display = 'none';
        }
    </script>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Admin Dashboard - Pendaftaran Seminar</h1>
            <form method="post" style="display: inline;">
                <button type="submit" name="logout" class="button" style="background: #dc3545;">Logout</button>
            </form>
        </div>
        <h3>Terdaftar :</h3>

        <table class="user-table" id="userList">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>NPM</th>
                    <th>Nama</th>
                    <th>Prodi</th>
                    <th>Email</th>
                    <th>Modifikasi</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($_SESSION['users'] as $index => $user): ?>
                    <?php
                    $filePath = 'proofs/registration_card_user_' . $user['npm'] . '.pdf';
                    ?>
                    <tr>
                        <td><?= $index + 1 ?></td>
                        <td><?= htmlspecialchars($user['npm']) ?></td>
                        <td><?= htmlspecialchars($user['nama']) ?></td>
                        <td><?= htmlspecialchars($user['prodi']) ?></td>
                        <td><?= htmlspecialchars($user['email']) ?></td>
                        <td>
                            <button onclick="showForm(true, <?= $index ?>, '<?= addslashes($user['npm']) ?>', '<?= addslashes($user['nama']) ?>', '<?= addslashes($user['prodi']) ?>', '<?= addslashes($user['email']) ?>')" class="button" style="background: #ffc107;">Edit</button>
                            <a href="?delete=<?= $index ?>" class="button" style="background: #dc3545;">Delete</a>
                            <a href="/bukti" class="button" style="background: #00ae2c;">Unduh</a>
                            <?php if (file_exists($filePath)): ?>
                                <a href="<?= $bukti ?>" download class="button" style="background: #00ae2c;">Unduh</a>
                            <?php else: ?>
                                <span style="color: gray;">No File</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <button class="button" onclick="showForm()">Tambah Mahasiswa</button>

        <div class="form" id="userForm">
            <h3 id="formTitle">Tambah Mahasiswa</h3>
            <form action="" method="POST">
                <label for="npm">NPM</label>
                <input type="text" id="npm" name="npm" placeholder="Masukkan NPM" required>
                <label for="nama">Nama</label>
                <input type="text" id="nama" name="nama" placeholder="Masukkan Nama" required>
                <label for="prodi">Prodi</label>
                <input type="text" id="prodi" name="prodi" placeholder="Masukkan Prodi" required>
                <label for="email">Email</label>
                <input type="email" id="email" name="email" placeholder="Masukkan Email" required>
                <input type="hidden" id="userId" name="userId">
                <button type="submit" class="button">Save</button>
                <button type="button" onclick="hideForm()" class="button" style="background: #6c757d; margin-top: 10px;">Cancel</button>
            </form>
        </div>
    </div>
</body>
</html>
