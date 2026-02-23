<?php
require __DIR__ . '/server/auth.php';
require __DIR__ . '/server/staff_crud.php';

require_login();
require_role('owner');

$flash = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $action = $_POST['action'] ?? '';
  if ($action === 'create') {
    $flash = create_staff($_POST['name'] ?? '', $_POST['email'] ?? '', $_POST['password'] ?? '');
  } elseif ($action === 'update') {
    $id = (int)($_POST['id'] ?? 0);
    $flash = update_staff($id, $_POST['name'] ?? '', $_POST['email'] ?? '', $_POST['password'] ?? null);
  } elseif ($action === 'toggle') {
    $id = (int)($_POST['id'] ?? 0);
    $active = (int)($_POST['active'] ?? 0);
    $flash = set_staff_active($id, $active);
  } else {
    $flash = ['ok'=>false,'message'=>'Unknown action.'];
  }

  // redirect to avoid resubmission
  $qs = $_SERVER['QUERY_STRING'] ?? '';
  header('Location: owner_staff.php' . ($qs ? '?'.$qs : '') . '&msg=' . urlencode(($flash['ok']?'ok: ':'err: ') . $flash['message']));
  exit;
}

$q = trim($_GET['q'] ?? '');
$status = $_GET['status'] ?? 'all';
$staff = list_staff($q, $status);

$msg = $_GET['msg'] ?? '';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Staff Accounts - TRIAD</title>
  <style>
    *{box-sizing:border-box;font-family:Arial,Helvetica,sans-serif}
    body{margin:0;background:#f3f4f6;color:#0f172a}
    .wrap{max-width:1100px;margin:0 auto;padding:18px}
    .top{display:flex;align-items:center;justify-content:space-between;gap:10px;flex-wrap:wrap}
    .card{background:#fff;border-radius:14px;padding:16px;box-shadow:0 6px 18px rgba(0,0,0,.06)}
    .btn{display:inline-block;border:0;border-radius:10px;padding:10px 14px;font-weight:700;cursor:pointer}
    .btn-primary{background:#1e3a8a;color:#fff}
    .btn-ghost{background:#eef2ff;color:#1e3a8a}
    .btn-danger{background:#fee2e2;color:#991b1b}
    a.btn{text-decoration:none}
    .grid{display:grid;grid-template-columns:1.2fr .8fr;gap:14px;margin-top:14px}
    @media (max-width:900px){.grid{grid-template-columns:1fr}}
    label{font-size:12px;color:#334155;font-weight:700}
    input,select{width:100%;padding:10px;border:1px solid #cbd5e1;border-radius:10px;margin-top:6px}
    .row{display:grid;grid-template-columns:1fr 1fr;gap:10px}
    @media (max-width:600px){.row{grid-template-columns:1fr}}
    table{width:100%;border-collapse:collapse;margin-top:10px}
    th,td{padding:10px;border-bottom:1px solid #e5e7eb;text-align:left;font-size:14px}
    th{font-size:12px;text-transform:uppercase;letter-spacing:.06em;color:#475569}
    .pill{display:inline-block;padding:4px 10px;border-radius:999px;font-size:12px;font-weight:800}
    .pill-on{background:#dcfce7;color:#166534}
    .pill-off{background:#fee2e2;color:#991b1b}
    .msg{margin-top:10px;padding:10px 12px;border-radius:12px;font-weight:700}
    .msg.ok{background:#dcfce7;color:#166534}
    .msg.err{background:#fee2e2;color:#991b1b}
    .actions{display:flex;gap:8px;flex-wrap:wrap}
    .small{font-size:12px;color:#64748b}
    .header{display:flex;gap:10px;align-items:center}
    .logo{width:44px;height:44px;border-radius:12px;object-fit:cover}
  </style>
</head>
<body>
  <div class="wrap">
    <div class="top">
      <div class="header">
        <img class="logo" src="images/logo.jpg" alt="Triad logo">
        <div>
          <div style="font-size:18px;font-weight:900;">Staff Accounts</div>
          <div class="small">Create, edit, and enable/disable staff logins.</div>
        </div>
      </div>
      <div class="actions">
        <a class="btn btn-ghost" href="owner.php">← Back to Owner</a>
        <a class="btn btn-danger" href="logout.php">Logout</a>
      </div>
    </div>

    <?php if ($msg): ?>
      <?php $cls = str_starts_with($msg,'ok:') ? 'ok' : 'err'; ?>
      <div class="msg <?php echo $cls; ?>"><?php echo htmlspecialchars($msg); ?></div>
    <?php endif; ?>

    <div class="grid">
      <div class="card">
        <div style="font-weight:900;margin-bottom:10px;">Create Staff Account</div>
        <form method="POST">
          <input type="hidden" name="action" value="create">
          <div class="row">
            <div>
              <label>Full Name</label>
              <input name="name" placeholder="e.g., Juan Dela Cruz" required>
            </div>
            <div>
              <label>Email</label>
              <input name="email" type="email" placeholder="e.g., staff@triad.com" required>
            </div>
          </div>
          <div style="margin-top:10px;">
            <label>Password</label>
            <input name="password" type="password" placeholder="Min 6 characters" required>
          </div>
          <div style="margin-top:12px;">
            <button class="btn btn-primary" type="submit">+ Create</button>
          </div>
        </form>
      </div>

      <div class="card">
        <div style="font-weight:900;margin-bottom:10px;">Search / Filter</div>
        <form method="GET">
          <label>Search (name or email)</label>
          <input name="q" value="<?php echo htmlspecialchars($q); ?>" placeholder="Search staff...">
          <div style="margin-top:10px;">
            <label>Status</label>
            <select name="status">
              <option value="all" <?php echo $status==='all'?'selected':''; ?>>All</option>
              <option value="active" <?php echo $status==='active'?'selected':''; ?>>Active</option>
              <option value="disabled" <?php echo $status==='disabled'?'selected':''; ?>>Disabled</option>
            </select>
          </div>
          <div style="margin-top:12px;">
            <button class="btn btn-ghost" type="submit">Apply</button>
          </div>
        </form>
      </div>
    </div>

    <div class="card" style="margin-top:14px;">
      <div style="display:flex;align-items:end;justify-content:space-between;gap:10px;flex-wrap:wrap;">
        <div style="font-weight:900;">Staff List (<?php echo count($staff); ?>)</div>
        <div class="small">Tip: Use “Edit” to change name/email/password. Use Disable to block login.</div>
      </div>

      <div style="overflow:auto;">
        <table>
          <thead>
            <tr>
              <th>Status</th>
              <th>Name</th>
              <th>Email</th>
              <th>Created</th>
              <th>Updated</th>
              <th style="width:360px;">Actions</th>
            </tr>
          </thead>
          <tbody>
          <?php if (!count($staff)): ?>
            <tr><td colspan="6" class="small">No staff accounts found.</td></tr>
          <?php endif; ?>

          <?php foreach ($staff as $s): ?>
            <tr>
              <td>
                <?php if ((int)$s['is_active'] === 1): ?>
                  <span class="pill pill-on">ACTIVE</span>
                <?php else: ?>
                  <span class="pill pill-off">DISABLED</span>
                <?php endif; ?>
              </td>
              <td><?php echo htmlspecialchars($s['name']); ?></td>
              <td><?php echo htmlspecialchars($s['email']); ?></td>
              <td class="small"><?php echo htmlspecialchars($s['created_at']); ?></td>
              <td class="small"><?php echo htmlspecialchars($s['updated_at'] ?? '-'); ?></td>
              <td>
                <!-- Edit form -->
                <form method="POST" style="display:grid;grid-template-columns:1fr 1fr 1fr auto;gap:8px;align-items:center;">
                  <input type="hidden" name="action" value="update">
                  <input type="hidden" name="id" value="<?php echo (int)$s['id']; ?>">
                  <input name="name" value="<?php echo htmlspecialchars($s['name']); ?>" required>
                  <input name="email" type="email" value="<?php echo htmlspecialchars($s['email']); ?>" required>
                  <input name="password" type="password" placeholder="New password (optional)">
                  <button class="btn btn-ghost" type="submit">Save</button>
                </form>

                <!-- Toggle -->
                <form method="POST" style="margin-top:8px;">
                  <input type="hidden" name="action" value="toggle">
                  <input type="hidden" name="id" value="<?php echo (int)$s['id']; ?>">
                  <?php if ((int)$s['is_active'] === 1): ?>
                    <input type="hidden" name="active" value="0">
                    <button class="btn btn-danger" type="submit">Disable</button>
                  <?php else: ?>
                    <input type="hidden" name="active" value="1">
                    <button class="btn btn-primary" type="submit">Enable</button>
                  <?php endif; ?>
                </form>
              </td>
            </tr>
          <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </div>

    <div class="small" style="margin-top:12px;">
      Note: Disabled staff cannot log in anymore (login will show “Account is disabled”).
    </div>
  </div>
</body>
</html>
