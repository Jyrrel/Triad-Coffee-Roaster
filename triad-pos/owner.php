<?php
require __DIR__ . '/server/auth.php';
require_login();
require_role('owner');
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Manager Dashboard - TRIAD COFFEE ROASTERS</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<style>
*{
  margin:0;
  padding:0;
  box-sizing:border-box;
  font-family:Arial, Helvetica, sans-serif;
}

body{
  display:flex;
  height:100vh;
  background:#f3f4f6;
}

/* =========================
   SIDEBAR (LIKE REF)
   ========================= */
.sidebar{
  width:240px;
  background:#ffffff;
  color:#111827;
  padding:16px;
  border-right:1px solid #eef2f7;
}

.brand{
  display:flex;
  gap:12px;
  align-items:center;
  padding:12px;
  border:1px solid #eef2f7;
  border-radius:16px;
  background:#ffffff;
  box-shadow:0 6px 18px rgba(17,24,39,0.06);
  margin-bottom:14px;
}

.brand img{
  width:46px;
  height:46px;
  border-radius:14px;
  object-fit:cover;
  background:#fff;
}

.brand-text{ line-height:1.1; }
.brand-title{
  font-weight:900;
  font-size:13px;
  letter-spacing:.5px;
}
.brand-sub{
  font-weight:900;
  font-size:12px;
}
.brand-role{
  margin-top:6px;
  font-size:11px;
  color:#6b7280;
  font-weight:700;
}

.menu-btn{
  width:100%;
  padding:12px;
  border:none;
  background:transparent;
  cursor:pointer;
  border-radius:14px;
  font-weight:900;
  color:#111827;

  display:flex;
  align-items:center;
  gap:10px;
  margin-bottom:8px;
}

.menu-btn .mi{
  width:34px;
  height:34px;
  display:flex;
  align-items:center;
  justify-content:center;
  border-radius:12px;
  background:#f3f4f6;
  font-size:16px;
}

.menu-btn .mt{ flex:1; text-align:left; }

.menu-btn:hover{ background:#f9fafb; }

.menu-btn.active{
  background:#ffe4e6;
  color:#be123c;
}
.menu-btn.active .mi{
  background:#fecdd3;
}

.side-badge{
  background:#ef4444;
  color:#fff;
  font-size:12px;
  padding:2px 8px;
  border-radius:999px;
  font-weight:900;
  display:none;
}

.sidebar-bottom{
  margin-top:14px;
  padding-top:12px;
  border-top:1px solid #eef2f7;
}

#logoutBtn{
  width:100%;
  padding:12px;
  border:none;
  border-radius:14px;
  cursor:pointer;
  font-weight:900;
  background:#111827;
  color:#fff;
}

/* =========================
   MAIN
   ========================= */
.main{
  flex:1;
  display:flex;
  flex-direction:column;
}

/* =========================
   HEADER (LIKE REF)
   ========================= */
.header{
  height:70px;
  background:#ffffff;
  display:flex;
  align-items:center;
  justify-content:space-between;
  padding:0 24px;
  box-shadow:0 2px 10px rgba(17,24,39,0.06);
  border-bottom:1px solid #eef2f7;
  gap:16px;
}

.header-left h2{
  margin:0;
  font-size:18px;
  font-weight:900;
  color:#111827;
}
.header-left p{
  margin:2px 0 0;
  font-size:12px;
  color:#6b7280;
  font-weight:700;
}

.header-mid{
  flex:1;
  display:flex;
  justify-content:center;
}

.search-wrap{
  width:min(520px, 100%);
  display:flex;
  align-items:center;
  gap:10px;
  background:#f3f4f6;
  border:1px solid #e5e7eb;
  border-radius:999px;
  padding:8px 14px;
}

.search-ico{ font-size:14px; opacity:.7; }

.search-wrap input{
  width:100%;
  border:none;
  outline:none;
  background:transparent;
  font-weight:700;
  font-size:13px;
  color:#111827;
}

.header-right{
  display:flex;
  align-items:center;
  gap:10px;
}

.bell{
  width:40px;
  height:40px;
  border-radius:12px;
  border:1px solid #e5e7eb;
  background:#fff;
  cursor:pointer;
  font-weight:900;
}

.user-badge{
  display:flex;
  align-items:center;
  gap:10px;
  padding:8px 12px;
  border-radius:14px;
  border:1px solid #e5e7eb;
  background:#fff;
}

.user-avatar{
  width:34px;
  height:34px;
  border-radius:50%;
  background:#dbeafe;
  display:flex;
  align-items:center;
  justify-content:center;
  font-weight:900;
  color:#1e3a8a;
  font-size:12px;
}

.user-text{ line-height:1.1; }
.user-name{
  font-size:12px;
  font-weight:900;
  color:#111827;
}
.user-role{
  font-size:11px;
  font-weight:700;
  color:#6b7280;
}

/* CONTENT */
.content{
  padding:25px;
  overflow-y:auto;
}

/* SECTION SWITCHING */
.section{ display:none; }
.section.active{ display:block; }

/* CARD */
.card{
  background:#fff;
  padding:20px;
  border-radius:12px;
  box-shadow:0 4px 10px rgba(0,0,0,0.05);
  margin-bottom: 20px;
}

.card h3{ margin-bottom:15px; }

/* TABLE */
table{
  width:100%;
  border-collapse:collapse;
  font-size:14px;
}

table th, table td{
  padding:8px 5px;
  border-bottom:1px solid #eee;
  text-align:left;
}

.green{color:green;font-weight:bold;}
.red{color:red;font-weight:bold;}

/* Dashboard top */
.dashboard-top {
  display: flex;
  justify-content: space-between;
  align-items: flex-start;
  margin-bottom: 25px;
  flex-wrap: wrap;
  gap: 20px;
}

.welcome-box {
  flex: 1 1 250px;
  font-size: 1.1rem;
  font-weight: 600;
  color: #1e3a8a;
}

/* ===== CALENDAR ===== */
.calendar-box {
  flex: 1 1 420px;
  max-width: 520px;
  background: #ffffff;
  border-radius: 10px;
  overflow: hidden;
  box-shadow: 0 4px 10px rgba(30,58,138,0.1);
}

.calendar-header {
  background: #6b8fc7;
  color: white;
  padding: 12px 15px;
}

.calendar-header h2 { font-size: 18px; font-weight: 600; }

.calendar-weekdays {
  display: grid;
  grid-template-columns: repeat(7, 1fr);
  background: #1e3a8a;
  color: white;
  font-size: 12px;
  text-align: center;
  padding: 6px 0;
}

.calendar-grid {
  display: grid;
  grid-template-columns: repeat(7, 1fr);
}

.calendar-grid div {
  border: 1px solid #e5e7eb;
  min-height: 50px;
  padding: 6px;
  font-size: 12px;
  background: #f9fafb;
  position:relative;
}

.other-month { color: #9ca3af; background: #f3f4f6; }

.day {
  font-weight: 900;
  color:#1e3a8a;
  cursor:pointer;
  transition: background .15s ease;
}
.day:hover{ background:#eef2ff; }

.highlight { background: #e0e7ff; }

.cal-dot{
  position:absolute;
  left:8px;
  bottom:7px;
  width:7px;
  height:7px;
  border-radius:50%;
  background:#2563eb;
}

/* ===== SALES REPORT STYLING ===== */
.sales-tabs {
  margin-top: 14px;
  display: flex;
  gap: 10px;
}

.tab-btn {
  background: #e0e7ff;
  border: none;
  padding: 8px 16px;
  border-radius: 20px;
  cursor: pointer;
  font-weight: 900;
  color: #1e40af;
  transition: background-color 0.25s ease;
}

.tab-btn:hover { background: #c7d2fe; }
.tab-btn.active { background: #1e40af; color: white; }

.chart-shell{
  margin-top:12px;
  background:#ffffff;
  border:1px solid #e5e7eb;
  border-radius:12px;
  padding:14px;
}

.chart-titleRow{
  display:flex;
  justify-content:space-between;
  align-items:center;
  gap:10px;
  margin-bottom:10px;
}
.chart-titleRow h4{
  margin:0;
  font-size:13px;
  font-weight:900;
  color:#111827;
}
.chart-legend{
  display:flex;
  gap:10px;
  align-items:center;
  font-size:12px;
  font-weight:800;
  color:#6b7280;
}
.legend-dot{
  width:10px;height:10px;border-radius:50%;
  background:#2563eb;
  display:inline-block;
  margin-right:6px;
}
.legend-dot2{ background:#22c55e; }

.chart-box{
  height:260px;
  background:linear-gradient(to bottom, #eef2ff, #ffffff);
  border-radius:12px;
  border:1px solid #eef2ff;
  padding:10px;
}
.chart-box canvas{
  width:100%;
  height:100%;
  display:block;
}

/* =========================
   STAFF
   ========================= */
.staff-wrap{ padding:4px; }

.staff-page-title{
  font-size:22px;
  font-weight:800;
  color:#111827;
  margin-bottom:14px;
}

.staff-statsRow{
  display:grid;
  grid-template-columns: repeat(4, minmax(180px, 1fr));
  gap:14px;
  margin-bottom:14px;
}

.staff-statCard{
  background:#ffffff;
  border-radius:14px;
  padding:14px 16px;
  box-shadow:0 4px 10px rgba(0,0,0,0.05);
  border:1px solid #eef2ff;
  display:flex;
  align-items:center;
  justify-content:space-between;
  min-height:76px;
}

.staff-statLeft{
  display:flex;
  gap:12px;
  align-items:center;
}

.staff-statIcon{
  width:36px;
  height:36px;
  border-radius:10px;
  display:flex;
  align-items:center;
  justify-content:center;
  font-weight:900;
  color:#111827;
  background:#f3f4f6;
}

.staff-statText small{
  display:block;
  color:#6b7280;
  font-size:12px;
  margin-bottom:4px;
}
.staff-statText b{
  font-size:18px;
  color:#111827;
}

.staff-filterRow{
  display:grid;
  grid-template-columns: 1.2fr 1fr 1fr 44px auto;
  gap:10px;
  align-items:center;
  margin-bottom:14px;
}

.staff-input, .staff-select{
  width:100%;
  padding:10px 12px;
  border-radius:10px;
  border:1px solid #e5e7eb;
  outline:none;
  background:#fff;
  font-weight:600;
  color:#111827;
}

.staff-searchBtn{
  width:44px;
  height:44px;
  border:none;
  border-radius:10px;
  background:#111827;
  color:white;
  cursor:pointer;
  font-weight:900;
}

.staff-addBtn{
  height:44px;
  border-radius:10px;
  border:1px solid #e5e7eb;
  background:#ffffff;
  cursor:pointer;
  font-weight:800;
  padding:0 14px;
}
.staff-addBtn:hover{ background:#f9fafb; }

.staff-grid{
  display:grid;
  grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
  gap:14px;
}

.emp-card{
  background:#ffffff;
  border-radius:14px;
  padding:14px;
  box-shadow:0 4px 10px rgba(0,0,0,0.05);
  border:1px solid #eef2ff;
}

.emp-top{
  display:flex;
  align-items:flex-start;
  justify-content:space-between;
  gap:10px;
}

.emp-avatar{
  width:54px;
  height:54px;
  border-radius:50%;
  background:#e0e7ff;
  display:flex;
  align-items:center;
  justify-content:center;
  font-weight:900;
  color:#1e3a8a;
}

.emp-name{
  margin:10px 0 2px;
  font-weight:900;
  color:#111827;
  font-size:14px;
}

.emp-role{
  font-size:12px;
  color:#6b7280;
  font-weight:700;
}

.emp-meta{
  margin-top:10px;
  display:grid;
  gap:6px;
  font-size:12px;
  color:#374151;
}

.emp-meta div{
  display:flex;
  justify-content:space-between;
  gap:10px;
}

.emp-badge{
  font-size:11px;
  font-weight:900;
  padding:4px 10px;
  border-radius:999px;
  white-space:nowrap;
  text-transform:capitalize;
}
.emp-badge.online{ background:#dcfce7; color:#166534; }
.emp-badge.offline{ background:#fee2e2; color:#991b1b; }

.emp-actions{
  margin-top:12px;
  display:flex;
  gap:10px;
}

.emp-actionBtn{
  width:34px;
  height:34px;
  border-radius:10px;
  border:1px solid #e5e7eb;
  background:#fff;
  cursor:pointer;
  font-weight:900;
}
.emp-actionBtn:hover{ background:#f9fafb; }

/* ============ LOW STOCK + HISTORY ============ */
.low-summary{
  display:flex;
  gap:10px;
  margin:12px 0 14px;
  flex-wrap:wrap;
}
.low-sumCard{
  background:#fff;
  border:1px solid #eef2ff;
  padding:10px 14px;
  border-radius:12px;
  box-shadow:0 2px 10px rgba(0,0,0,0.05);
  font-size:13px;
  font-weight:800;
}
.low-sumCard b{ font-size:16px; margin-left:8px; }

.low-filters{
  display:flex;
  gap:8px;
  margin:8px 0 14px;
  flex-wrap:wrap;
}
.low-filterBtn{
  padding:8px 12px;
  border:none;
  border-radius:10px;
  background:#e5e7eb;
  cursor:pointer;
  font-weight:900;
}
.low-filterBtn.active{ background:#2563eb; color:#fff; }

.badge{
  display:inline-block;
  padding:6px 12px;
  border-radius:999px;
  font-size:12px;
  font-weight:900;
}
.badge-in{ background:#e8fff0; color:#0f7a3a; }
.badge-low{ background:#fff4d6; color:#9a6b00; }
.badge-out{ background:#ffe3e3; color:#b10000; }

.row-low{ background:#fffdf3; }
.row-out{ background:#fff5f5; }

.btn-restock{
  background:#2563eb;
  color:white;
  border:none;
  padding:6px 12px;
  border-radius:6px;
  cursor:pointer;
  font-weight:900;
}

/* modal (shared) */
.modal{
  position:fixed;
  inset:0;
  background:rgba(0,0,0,.35);
  display:none;
  align-items:center;
  justify-content:center;
  z-index:999;
}
.modal.show{ display:flex; }

.modal-box{
  width:420px;
  max-width:92vw;
  background:#fff;
  border-radius:14px;
  padding:16px;
  box-shadow:0 10px 30px rgba(0,0,0,.15);
}
.modal-box h3{ margin:0 0 6px; }
.modal-box .muted{ color:#6b7280; font-size:13px; margin-bottom:10px; }
.modal-box label{ font-size:12px; font-weight:900; color:#111827; }
.modal-box input{
  width:100%;
  margin-top:6px;
  padding:10px;
  border:1px solid #ddd;
  border-radius:10px;
  outline:none;
  font-weight:700;
}

.modal-actions{
  display:flex;
  justify-content:flex-end;
  gap:10px;
  margin-top:14px;
}
.btn-primary{
  background:#2563eb; color:#fff; border:none;
  padding:10px 14px; border-radius:10px; cursor:pointer; font-weight:900;
}
.btn-ghost{
  background:#f3f4f6; border:none;
  padding:10px 14px; border-radius:10px; cursor:pointer; font-weight:900;
}

#historyTable th, #historyTable td{
  padding:8px 6px;
  border-bottom:1px solid #eee;
  text-align:left;
  font-size:13px;
}

@media (max-width: 1100px){
  .staff-statsRow{ grid-template-columns: repeat(2, minmax(180px, 1fr)); }
  .staff-filterRow{ grid-template-columns: 1fr 1fr 44px auto; }
  .staff-filterRow .priorityWrap{ display:none; }
  .header-mid{ display:none; }
}

/* ===========================
   DASHBOARD SLIDESHOW (ADD ONLY)
   =========================== */
.slide-card{
  margin-top:14px;
  background:#fff;
  border:1px solid #eef2f7;
  border-radius:16px;
  box-shadow:0 6px 18px rgba(17,24,39,0.06);
  padding:12px;
  max-width:520px;
}

.slide-wrap{
  position:relative;
  overflow:hidden;
  border-radius:14px;
  height:260px;
  background:#f3f4f6;
}

.slide-img{
  position:absolute;
  inset:0;
  width:100%;
  height:100%;
  object-fit:cover;
  opacity:0;
  transform:scale(1.02);
  transition:opacity .35s ease, transform .35s ease;
}

.slide-img.active{
  opacity:1;
  transform:scale(1);
}

.slide-nav{
  position:absolute;
  top:50%;
  transform:translateY(-50%);
  width:40px;
  height:40px;
  border:none;
  border-radius:12px;
  cursor:pointer;
  font-weight:900;
  font-size:22px;
  background:rgba(255,255,255,.92);
  box-shadow:0 6px 18px rgba(0,0,0,.12);
}
.slide-nav.prev{ left:10px; }
.slide-nav.next{ right:10px; }

.slide-dots{
  position:absolute;
  left:50%;
  bottom:10px;
  transform:translateX(-50%);
  display:none;
}

.slide-dot{
  width:8px;
  height:8px;
  border-radius:50%;
  border:none;
  cursor:pointer;
  background:rgba(255,255,255,.6);
}
.slide-dot.active{ background:#fff; }

/* ===== SLIDER OVERRIDE (ADD ONLY) ===== */
.slide-card{ max-width: 640px; }
.slide-wrap{ height: 290px; }

/* alisin arrows */
.slide-nav{ display:none !important; }
.slide-dots{ display:none !important; }
</style>
</head>

<body>

<!-- SIDEBAR -->
<div class="sidebar">
  <div class="brand">
    <img src="images/logo.jpg" alt="Triad Logo">
    <div class="brand-text">
      <div class="brand-title">TRIAD COFFEE</div>
      <div class="brand-sub">ROASTERS</div>
      <div class="brand-role">Manager Panel</div>
    </div>
  </div>

  <button class="menu-btn active" data-target="dashboard" data-title="Dashboard" data-sub="Manager Overview">
    <span class="mi">🏠</span><span class="mt">Dashboard</span>
  </button>

  <button class="menu-btn" data-target="sales" data-title="Sales Reports" data-sub="Daily / Weekly / Monthly">
    <span class="mi">📈</span><span class="mt">Sales Reports</span>
  </button>

  <button class="menu-btn" data-target="inventory" data-title="Inventory" data-sub="Stocks and status">
    <span class="mi">📦</span><span class="mt">Inventory</span>
  </button>

  <button class="menu-btn" data-target="lowstock" data-title="Low Stock" data-sub="Critical items and restock">
    <span class="mi">⚠️</span><span class="mt">Low Stock</span>
    <span class="side-badge" id="sideLowBadge">0</span>
  </button>

  <button class="menu-btn" data-target="staff" data-title="Staff Activity" data-sub="Employees status">
    <span class="mi">👥</span><span class="mt">Staff Activity</span>
  </button>

  <div class="sidebar-bottom">
    <button id="logoutBtn">Logout</button>
  </div>
</div>

<!-- MAIN -->
<div class="main">

  <div class="header">
    <div class="header-left">
      <h2 id="headerTitle">Dashboard</h2>
      <p id="headerSub">Manager Overview</p>
    </div>

    <div class="header-mid">
      <div class="search-wrap">
        <span class="search-ico">🔎</span>
        <input type="text" placeholder="Search coffee, drinks, inventory..." aria-label="search">
      </div>
    </div>

    <div class="header-right">
      <button class="bell" type="button" title="Notifications">🔔</button>

      <div class="user-badge" title="User">
        <div class="user-avatar">TC</div>
        <div class="user-text">
          <div class="user-name">Triad Staff</div>
          <div class="user-role">Manager</div>
        </div>
      </div>
    </div>
  </div>

  <div class="content">

    <!-- DASHBOARD -->
    <div id="dashboard" class="section active">
      <div class="dashboard-top">
        <div class="welcome-box">
          <h3>Welcome back, user!</h3>
          <p>Click a date to add activities:</p>

          <div class="slide-card">
            <div class="slide-wrap" id="dashSlider">
              <img class="slide-img active" src="images/blend.jpg" alt="Blend">
              <img class="slide-img" src="images/Espresso.jpg" alt="Espresso">
              <img class="slide-img" src="images/MT%20APO.jpg" alt="MT APO">
              <img class="slide-img" src="images/PCQC.jpg" alt="PCQC">
              <button class="slide-nav prev" type="button" aria-label="Previous">‹</button>
              <button class="slide-nav next" type="button" aria-label="Next">›</button>
            </div>
          </div>
        </div>

        <div class="calendar-box">
          <div class="calendar-header">
            <h2>January 2026</h2>
          </div>

          <div class="calendar-weekdays">
            <div>Sun</div><div>Mon</div><div>Tue</div>
            <div>Wed</div><div>Thu</div><div>Fri</div><div>Sat</div>
          </div>

          <div class="calendar-grid">
            <div class="other-month">28</div>
            <div class="other-month">29</div>
            <div class="other-month">30</div>
            <div class="other-month">31</div>

            <div class="day highlight" data-date="2026-01-01">1</div>
            <div class="day" data-date="2026-01-02">2</div>
            <div class="day" data-date="2026-01-03">3</div>

            <div class="day" data-date="2026-01-04">4</div>
            <div class="day" data-date="2026-01-05">5</div>
            <div class="day" data-date="2026-01-06">6</div>
            <div class="day" data-date="2026-01-07">7</div>
            <div class="day" data-date="2026-01-08">8</div>
            <div class="day" data-date="2026-01-09">9</div>
            <div class="day" data-date="2026-01-10">10</div>

            <div class="day" data-date="2026-01-11">11</div>
            <div class="day" data-date="2026-01-12">12</div>
            <div class="day" data-date="2026-01-13">13</div>
            <div class="day" data-date="2026-01-14">14</div>
            <div class="day" data-date="2026-01-15">15</div>
            <div class="day" data-date="2026-01-16">16</div>
            <div class="day" data-date="2026-01-17">17</div>

            <div class="day" data-date="2026-01-18">18</div>
            <div class="day" data-date="2026-01-19">19</div>
            <div class="day" data-date="2026-01-20">20</div>
            <div class="day" data-date="2026-01-21">21</div>
            <div class="day" data-date="2026-01-22">22</div>
            <div class="day" data-date="2026-01-23">23</div>
            <div class="day" data-date="2026-01-24">24</div>

            <div class="day" data-date="2026-01-25">25</div>
            <div class="day" data-date="2026-01-26">26</div>
            <div class="day" data-date="2026-01-27">27</div>
            <div class="day" data-date="2026-01-28">28</div>
            <div class="day" data-date="2026-01-29">29</div>
            <div class="day" data-date="2026-01-30">30</div>
            <div class="day" data-date="2026-01-31">31</div>
          </div>
        </div>
      </div>

      <div class="card">
        <h3>All Scheduled Activities</h3>
        <ul id="allActivitiesList" style="list-style:none;padding:0;"></ul>
      </div>

      <div class="card">
        <h3>Top Selling Products</h3>
        <table>
          <tr><th>Jyrrel</th><th>Units</th><th>Revenue</th></tr>
          <tr><td>Akimaru</td><td>45</td><td>₱6,750</td></tr>
          <tr><td>Josh</td><td>40</td><td>₱4,800</td></tr>
          <tr><td>Ramon</td><td>38</td><td>₱3,040</td></tr>
          <tr><td>Gaborne</td><td>32</td><td>₱2,880</td></tr>
          <tr><td>Marven</td><td>28</td><td>₱3,920</td></tr>
        </table>
      </div>
    </div>

    <!-- SALES -->
    <div id="sales" class="section">
      <div class="card">
        <div class="stats-grid" style="display:flex; gap:20px; margin-bottom: 20px;">
          <div style="flex:1; background:#fff; padding:15px; border-radius:12px; box-shadow:0 4px 10px rgba(0,0,0,0.05);">
            <h4 style="font-size:14px; color:#555; margin-bottom:5px;">Total Sales Today</h4>
            <h2 style="margin:0;">₱25,430</h2>
            <span style="color:green; font-weight:bold;">▲ 12%</span>
          </div>
          <div style="flex:1; background:#fff; padding:15px; border-radius:12px; box-shadow:0 4px 10px rgba(0,0,0,0.05);">
            <h4 style="font-size:14px; color:#555; margin-bottom:5px;">Total Orders</h4>
            <h2 style="margin:0;">120</h2>
            <span style="color:green; font-weight:bold;">▲ 8%</span>
          </div>
          <div style="flex:1; background:#fff; padding:15px; border-radius:12px; box-shadow:0 4px 10px rgba(0,0,0,0.05);">
            <h4 style="font-size:14px; color:#555; margin-bottom:5px;">Revenue</h4>
            <h2 style="margin:0;">₱18,900</h2>
            <span style="color:green; font-weight:bold;">▲ 15%</span>
          </div>
        </div>

        <h3 style="font-size: 16px; font-weight: 900; margin-bottom: 6px;">Sales Overview</h3>
        <div class="sales-tabs">
          <button class="tab-btn active" data-period="daily">Daily</button>
          <button class="tab-btn" data-period="weekly">Weekly</button>
          <button class="tab-btn" data-period="monthly">Monthly</button>
        </div>

        <div class="sales-content">

          <div class="sales-chart" id="daily" style="display:block;">
            <div class="chart-shell">
              <div class="chart-titleRow">
                <h4>DAILY SALES</h4>
                <div class="chart-legend">
                  <span><span class="legend-dot"></span>SALES</span>
                  <span><span class="legend-dot legend-dot2"></span>ORDERS</span>
                </div>
              </div>
              <div class="chart-box"><canvas id="dailyCanvas"></canvas></div>
            </div>
          </div>

          <div class="sales-chart" id="weekly" style="display:none;">
            <div class="chart-shell">
              <div class="chart-titleRow">
                <h4>WEEKLY SALES</h4>
                <div class="chart-legend">
                  <span><span class="legend-dot"></span>SALES</span>
                  <span><span class="legend-dot legend-dot2"></span>ORDERS</span>
                </div>
              </div>
              <div class="chart-box"><canvas id="weeklyCanvas"></canvas></div>
            </div>
          </div>

          <div class="sales-chart" id="monthly" style="display:none;">
            <div class="chart-shell">
              <div class="chart-titleRow">
                <h4>MONTHLY SALES</h4>
                <div class="chart-legend">
                  <span><span class="legend-dot"></span>SALES</span>
                  <span><span class="legend-dot legend-dot2"></span>ORDERS</span>
                </div>
              </div>
              <div class="chart-box"><canvas id="monthlyCanvas"></canvas></div>
            </div>
          </div>

        </div>
      </div>
    </div>

    <!-- LOW STOCK -->
    <div id="lowstock" class="section">

      <div class="low-summary">
        <div class="low-sumCard">TOTAL ITEMS <b id="sumTotal">0</b></div>
        <div class="low-sumCard">LOW STOCK <b id="sumLow">0</b></div>
        <div class="low-sumCard">OUT OF STOCK <b id="sumOut">0</b></div>
      </div>

      <div class="low-filters">
        <button class="low-filterBtn active" data-cat="all">All</button>
        <button class="low-filterBtn" data-cat="beans">Beans</button>
        <button class="low-filterBtn" data-cat="dairy">Dairy</button>
        <button class="low-filterBtn" data-cat="pastry">Pastry</button>
        <button class="low-filterBtn" data-cat="others">Others</button>
      </div>

      <div class="card">
        <h3 style="margin-bottom:15px;">Low Stock Items</h3>
        <table id="lowStockTable">
          <tr>
            <th>Product</th>
            <th>Current Stock</th>
            <th>Min Level</th>
            <th>Status</th>
            <th>Last Updated</th>
            <th>Action</th>
          </tr>
        </table>
      </div>

      <div class="card">
        <h3 style="color:#dc2626; margin-bottom:10px;">⚠ Critical Stock Alert</h3>
        <p><strong id="criticalText">0 items critically low on stock!</strong></p>
        <ul id="alertList"></ul>
      </div>

      <div class="card">
        <div style="display:flex; justify-content:space-between; align-items:center; gap:10px; flex-wrap:wrap;">
          <h3 style="margin:0;">Restock History</h3>
          <button id="clearHistoryBtn" type="button" style="
            background:#f3f4f6; border:none; padding:8px 12px; border-radius:10px;
            cursor:pointer; font-weight:900;
          ">Clear History</button>
        </div>

        <div style="overflow:auto; margin-top:10px;">
          <table id="historyTable">
            <tr>
              <th>Date/Time</th>
              <th>Product</th>
              <th>Added</th>
              <th>From</th>
              <th>To</th>
            </tr>
          </table>
        </div>

        <p id="historyEmpty" style="color:#6b7280; font-size:13px; margin-top:10px;">
          No restock history yet.
        </p>
      </div>
    </div>

    <!-- STAFF -->
    <div id="staff" class="section">
      <div class="staff-wrap">
        <div class="staff-page-title">Employee</div>

        <div class="staff-statsRow">
          <div class="staff-statCard">
            <div class="staff-statLeft">
              <div class="staff-statIcon">👥</div>
              <div class="staff-statText">
                <small>Total Employee</small>
                <b id="totalStaff">0</b>
              </div>
            </div>
          </div>

          <div class="staff-statCard">
            <div class="staff-statLeft">
              <div class="staff-statIcon">➕</div>
              <div class="staff-statText">
                <small>New Employee</small>
                <b id="newStaff">0</b>
              </div>
            </div>
          </div>

          <div class="staff-statCard">
            <div class="staff-statLeft">
              <div class="staff-statIcon">🟢</div>
              <div class="staff-statText">
                <small>Online</small>
                <b id="onlineStaff">0</b>
              </div>
            </div>
          </div>

          <div class="staff-statCard">
            <div class="staff-statLeft">
              <div class="staff-statIcon">🔴</div>
              <div class="staff-statText">
                <small>Offline</small>
                <b id="offlineStaff">0</b>
              </div>
            </div>
          </div>
        </div>

        <div class="staff-filterRow">
          <input id="staffSearch" class="staff-input" type="text" placeholder="Employee Name">

          <select id="staffStatusFilter" class="staff-select">
            <option value="all">Select Status</option>
            <option value="online">Online</option>
            <option value="offline">Offline</option>
          </select>

          <div class="priorityWrap">
            <select id="staffPriority" class="staff-select">
              <option value="all">Select Priority</option>
              <option value="high">High</option>
              <option value="normal">Normal</option>
            </select>
          </div>

          <button class="staff-searchBtn" type="button" id="staffSearchBtn">⌕</button>
          <a class="staff-addBtn" href="owner_staff.php" style="text-decoration:none;display:inline-block;line-height:1;">+ Create Account</a>
          <a class="staff-addBtn" href="owner_staff.php" style="text-decoration:none;display:inline-block;line-height:1;background:#eef2ff;color:#1e3a8a;border:1px solid #c7d2fe;">Manage Staff</a>
        </div>

        <div id="staffGrid" class="staff-grid"></div>
      </div>
    </div>

    <!-- INVENTORY -->
    <div id="inventory" class="section">
      <div class="card">
        <h2 style="margin-bottom:5px;">Inventory Management</h2>
        <p style="color:#666; font-size:13px; margin-bottom:20px;">
          Today, August 16th 2024
        </p>

        <div style="display:flex; gap:20px; flex-wrap:wrap; margin-bottom:25px;">
          <div style="flex:1; min-width:200px; background:#f9fafb; padding:15px; border-radius:10px;">
            <h4>Total Items</h4>
            <p style="color:#666; font-size:13px;">Total items in stock</p>
            <h2>120</h2>
          </div>

          <div style="flex:1; min-width:200px; background:#f9fafb; padding:15px; border-radius:10px;">
            <h4>Low Stock Items</h4>
            <p style="color:#666; font-size:13px;">Number of items that are running low</p>
            <h2 style="color:orange;">8</h2>
          </div>

          <div style="flex:1; min-width:200px; background:#f9fafb; padding:15px; border-radius:10px;">
            <h4>Expired Items</h4>
            <p style="color:#666; font-size:13px;">Number of items past their expiration date</p>
            <h2 style="color:red;">40</h2>
          </div>

          <div style="flex:1; min-width:200px; background:#f9fafb; padding:15px; border-radius:10px;">
            <h4>Out of Stock Items</h4>
            <p style="color:#666; font-size:13px;">Count of items currently out of stock</p>
            <h2 style="color:#b91c1c;">15</h2>
          </div>
        </div>

        <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:15px;">
          <h3 style="margin:0;">Inventory Overview</h3>

         <div style="display:flex; gap:10px; align-items:center;">
  <select id="inventoryFilter" style="
    padding:8px 12px;
    border-radius:6px;
    border:1px solid #ccc;
    cursor:pointer;
    font-weight:600;
  ">
    <option value="all">All</option>
    <option value="good">Good</option>
    <option value="low stock">Low Stock</option>
    <option value="out of stock">Out of Stock</option>
    <option value="expired">Expired</option>
  </select>

  <input id="inventorySearch" type="text" placeholder="Search item..."
    style="
      padding:8px 12px;
      border-radius:6px;
      border:1px solid #ccc;
      font-weight:600;
      outline:none;
      width:220px;
    ">
</div>
        </div>

        <table id="inventoryTable">
       <tr>
  <td>Filter Brew</td>
  <td>20cups</td>
  <td>Bar</td>
  <td>Aug 15, 2024</td>
  <td class="green">Good</td>
</tr>

<tr>
  <td>White Brew</td>
  <td>6cups</td>
  <td>Bar</td>
  <td>Aug 15, 2024</td>
  <td style="color:orange; font-weight:bold;">Low Stock</td>
</tr>

<tr>
  <td>OAT White Brew</td>
  <td>4cups</td>
  <td>Bar</td>
  <td>Aug 15, 2024</td>
  <td style="color:orange; font-weight:bold;">Low Stock</td>
</tr>

<tr>
  <td>Latte / Flat White</td>
  <td>18cups</td>
  <td>Bar</td>
  <td>Aug 15, 2024</td>
  <td class="green">Good</td>
</tr>

<tr>
  <td>Cappuccino / Cortado</td>
  <td>10cups</td>
  <td>Bar</td>
  <td>Aug 15, 2024</td>
  <td class="green">Good</td>
</tr>

<tr>
  <td>Ice Latte</td>
  <td>5cups</td>
  <td>Bar</td>
  <td>Aug 15, 2024</td>
  <td style="color:orange; font-weight:bold;">Low Stock</td>
</tr>

<tr>
  <td>Long Black</td>
  <td>12cups</td>
  <td>Bar</td>
  <td>Aug 15, 2024</td>
  <td class="green">Good</td>
</tr>

<tr>
  <td>Espresso Double / Single</td>
  <td>25shots</td>
  <td>Bar</td>
  <td>Aug 15, 2024</td>
  <td class="green">Good</td>
</tr>

<tr>
  <td>Ice Matcha</td>
  <td>3cups</td>
  <td>Bar</td>
  <td>Aug 15, 2024</td>
  <td class="red">Out of Stock</td>
</tr>

<tr>
  <td>Matcha Latte</td>
  <td>8cups</td>
  <td>Bar</td>
  <td>Aug 15, 2024</td>
  <td class="green">Good</td>
</tr>

<tr>
  <td>Make it OAT</td>
  <td>2L</td>
  <td>Chiller</td>
  <td>Aug 15, 2024</td>
  <td style="color:orange; font-weight:bold;">Low Stock</td>
</tr>

<tr>
  <td>Blueberry Muffin</td>
  <td>10pcs</td>
  <td>Display</td>
  <td>Aug 15, 2024</td>
  <td style="color:orange; font-weight:bold;">Low Stock</td>
</tr>

<tr>
  <td>Chocolate Lava Muffin</td>
  <td>15pcs</td>
  <td>Display</td>
  <td>Aug 15, 2024</td>
  <td class="green">Good</td>
</tr>

<tr>
  <td>Matcha Chips</td>
  <td>12pcs</td>
  <td>Display</td>
  <td>Aug 15, 2024</td>
  <td class="green">Good</td>
</tr>

<tr>
  <td>Chocolate Chips</td>
  <td>5pcs</td>
  <td>Display</td>
  <td>Aug 15, 2024</td>
  <td style="color:orange; font-weight:bold;">Low Stock</td>
</tr>

<tr>
  <td>Plain Croissant</td>
  <td>0pcs</td>
  <td>Display</td>
  <td>Aug 15, 2024</td>
  <td class="red">Out of Stock</td>
</tr>

<tr>
  <td>Two Mountains</td>
  <td>15kg</td>
  <td>Dry Storage</td>
  <td>Aug 15, 2024</td>
  <td class="green">Good</td>
</tr>

<tr>
  <td>Lanao Del Sur Amai Manabilang</td>
  <td>6kg</td>
  <td>Dry Storage</td>
  <td>Aug 15, 2024</td>
  <td style="color:orange; font-weight:bold;">Low Stock</td>
</tr>

<tr>
  <td>Mt. Apo</td>
  <td>12kg</td>
  <td>Dry Storage</td>
  <td>Aug 15, 2024</td>
  <td class="green">Good</td>
</tr>

<tr>
  <td>Winow</td>
  <td>4kg</td>
  <td>Dry Storage</td>
  <td>Aug 15, 2024</td>
  <td style="color:orange; font-weight:bold;">Low Stock</td>
</tr>

<tr>
  <td>Dark Fruit</td>
  <td>0kg</td>
  <td>Dry Storage</td>
  <td>Aug 15, 2024</td>
  <td class="red">Out of Stock</td>
</tr>
        </table>
      </div>
    </div>

  </div>
</div>

<!-- Restock Modal -->
<div class="modal" id="restockModal">
  <div class="modal-box">
    <h3>RESTOCK</h3>
    <p class="muted" id="modalSub">Add quantity for:</p>

    <label>Quantity to add</label>
    <input type="number" id="restockQty" min="1" placeholder="e.g. 10">

    <div class="modal-actions">
      <button id="cancelRestock" class="btn-ghost" type="button">Cancel</button>
      <button id="confirmRestock" class="btn-primary" type="button">Confirm</button>
    </div>
  </div>
</div>

<!-- Calendar Activity Modal -->
<div class="modal" id="calendarModal">
  <div class="modal-box">
    <h3>Manage Activities</h3>
    <p class="muted" id="calendarDateText"></p>

    <label>New Activity</label>
    <input type="text" id="calendarActivityInput" placeholder="Enter activity">

    <div class="modal-actions">
      <button id="calendarAdd" class="btn-primary" type="button">Add</button>
      <button id="calendarClose" class="btn-ghost" type="button">Close</button>
    </div>

    <div style="margin-top:15px;">
      <h4 style="margin-bottom:6px; font-size:14px;">Activities:</h4>
      <ul id="calendarActivityList" style="list-style:none;padding:0;"></ul>
    </div>
  </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function () {

  /* =======================
     SIDEBAR SWITCH + HEADER
     ======================= */
  const buttons = document.querySelectorAll(".menu-btn");
  const sections = document.querySelectorAll(".section");
  const logoutBtn = document.getElementById("logoutBtn");

  const headerTitle = document.getElementById("headerTitle");
  const headerSub = document.getElementById("headerSub");

  buttons.forEach(button => {
    button.addEventListener("click", function () {
      buttons.forEach(btn => btn.classList.remove("active"));
      this.classList.add("active");

      sections.forEach(section => section.classList.remove("active"));
      const target = this.getAttribute("data-target");
      const targetSection = document.getElementById(target);
      if (targetSection) targetSection.classList.add("active");

      headerTitle.textContent = this.getAttribute("data-title") || "Dashboard";
      headerSub.textContent = this.getAttribute("data-sub") || "Manager Overview";

      // ✅ AUTO APPLY INVENTORY FILTER WHEN OPEN INVENTORY TAB
      if (target === "inventory") {
        setTimeout(applyInvFilter, 0);
      }
    });     
  });

  logoutBtn.addEventListener("click", function () {
    window.location.href = "logout.php";
  });

  /* =======================
     SALES TABS
     ======================= */
  const tabButtons = document.querySelectorAll(".tab-btn");
  const salesCharts = document.querySelectorAll(".sales-chart");

  tabButtons.forEach(btn => {
    btn.addEventListener("click", () => {
      tabButtons.forEach(b => b.classList.remove("active"));
      btn.classList.add("active");

      const period = btn.getAttribute("data-period");
      salesCharts.forEach(chart => {
        chart.style.display = (chart.id === period) ? "block" : "none";
      });

      drawAllCharts();
    });
  });

  /* =======================
     STAFF (DUMMY DATA)
     ======================= */
  const staffGrid = document.getElementById("staffGrid");
  const staffSearch = document.getElementById("staffSearch");
  const staffStatusFilter = document.getElementById("staffStatusFilter");
  const staffSearchBtn = document.getElementById("staffSearchBtn");

  const totalStaffEl = document.getElementById("totalStaff");
  const newStaffEl = document.getElementById("newStaff");
  const onlineStaffEl = document.getElementById("onlineStaff");
  const offlineStaffEl = document.getElementById("offlineStaff");

  let staffData = [
    { id: 1, name: "Ruben Korsgaard", position: "Frontend Developer", status: "online", joinDate: "2/4/2023" },
    { id: 2, name: "Ruben Korsgaard", position: "Backend Developer", status: "offline", joinDate: "2/4/2023" },
    { id: 3, name: "Ruben Korsgaard", position: "Barista", status: "online", joinDate: "2/4/2023" },
    { id: 4, name: "Ruben Korsgaard", position: "Cashier", status: "offline", joinDate: "2/4/2023" },
    { id: 5, name: "Ruben Korsgaard", position: "Kitchen Staff", status: "online", joinDate: "2/4/2023" },
    { id: 6, name: "Ruben Korsgaard", position: "Manager", status: "offline", joinDate: "2/4/2023" }
  ];

  function renderStaffCards(list){
    totalStaffEl.textContent = staffData.length;

    const onlineCount = staffData.filter(s => s.status === "online").length;
    onlineStaffEl.textContent = onlineCount;
    offlineStaffEl.textContent = staffData.length - onlineCount;

    newStaffEl.textContent = Math.min(2, staffData.length);

    staffGrid.innerHTML = "";

    if (list.length === 0){
      staffGrid.innerHTML = `<div style="color:#6b7280; padding:10px;">No employee found.</div>`;
      return;
    }

    list.forEach(s => {
      const initials = s.name.split(" ").slice(0,2).map(x => x[0]).join("").toUpperCase();
      staffGrid.innerHTML += `
        <div class="emp-card">
          <div class="emp-top">
            <div class="emp-avatar">${initials}</div>
            <span class="emp-badge ${s.status}">${s.status}</span>
          </div>

          <div class="emp-name">${s.name}</div>
          <div class="emp-role">${s.position}</div>

          <div class="emp-meta">
            <div><b>Employee id</b><span>FD-${String(s.id).padStart(3,"0")}</span></div>
            <div><b>Join Date</b><span>${s.joinDate}</span></div>
          </div>

          <div class="emp-actions">
            <button class="emp-actionBtn" type="button">☎</button>
            <button class="emp-actionBtn" type="button">✉</button>
            <button class="emp-actionBtn" type="button">⋯</button>
          </div>
        </div>
      `;
    });
  }

  function applyStaffFilters(){
    const q = (staffSearch.value || "").toLowerCase();
    const status = staffStatusFilter.value || "all";

    let filtered = staffData.filter(s => s.name.toLowerCase().includes(q));
    if (status !== "all"){
      filtered = filtered.filter(s => s.status === status);
    }
    renderStaffCards(filtered);
  }

  staffSearch.addEventListener("input", applyStaffFilters);
  staffStatusFilter.addEventListener("change", applyStaffFilters);
  staffSearchBtn.addEventListener("click", applyStaffFilters);

  renderStaffCards(staffData);

  /* =======================
   CREATE ACCOUNT FUNCTION
   ======================= */

const createModal = document.getElementById("createAccountModal");
const openCreateBtn = document.getElementById("addStaffBtn");
const cancelCreate = document.getElementById("cancelCreate");
const saveCreate = document.getElementById("saveCreate");

const newName = document.getElementById("newName");
const newPosition = document.getElementById("newPosition");
const newStatus = document.getElementById("newStatus");

openCreateBtn.addEventListener("click", () => {
  newName.value = "";
  newPosition.value = "";
  newStatus.value = "online";
  createModal.classList.add("show");
});

cancelCreate.addEventListener("click", () => {
  createModal.classList.remove("show");
});

saveCreate.addEventListener("click", () => {

  const name = newName.value.trim();
  const position = newPosition.value.trim();
  const status = newStatus.value;

  if (!name || !position) {
    alert("Please fill in all fields.");
    return;
  }

  const newId = staffData.length
    ? staffData[staffData.length - 1].id + 1
    : 1;

  staffData.push({
    id: newId,
    name: name,
    position: position,
    status: status,
    joinDate: new Date().toLocaleDateString()
  });

  createModal.classList.remove("show");
  renderStaffCards(staffData);
});

  /* ================= LOW STOCK + HISTORY ================= */
  const MIN_LEVELS = {
  "Filter Brew": 8,
  "White Brew": 8,
  "OAT White Brew": 6,
  "Latte / Flat White": 8,
  "Cappuccino / Cortado": 8,
  "Ice Latte": 8,
  "Long Black": 8,
  "Espresso Double / Single": 10,
  "Ice Matcha": 5,
  "Matcha Latte": 6,
  "Make it OAT": 5,
  "Blueberry Muffin": 15,
  "Chocolate Lava Muffin": 10,
  "Matcha Chips": 10,
  "Chocolate Chips": 10,
  "Plain Croissant": 12,
  "Two Mountains": 10,
  "Lanao Del Sur Amai Manabilang": 8,
  "Mt. Apo": 10,
  "Winow": 6,
  "Dark Fruit": 8
};

  const CATEGORIES = {
    "Filter Brew Beans": "beans",
    "White Brew Beans": "beans",
    "Mt. Apo Beans": "beans",
    "Oat Milk": "dairy",
    "Matcha Powder": "others",
    "Blueberry Muffin": "pastry"
  };

  function parseQty(text){
    const t = (text || "").trim();
    const num = parseFloat(t.replace(/[^\d.]/g, "")) || 0;
    const unit = (t.replace(/[\d.\s]/g, "") || "").trim() || "";
    return { num, unit };
  }

  function nowText(){ return new Date().toLocaleString(); }

  function statusFromStock(stockNum, minNum){
    if (stockNum === 0) return "OUT OF STOCK";
    if (stockNum <= minNum) return "LOW STOCK";
    return "IN STOCK";
  }

  function badgeHTML(status){
    if (status === "OUT OF STOCK") return `<span class="badge badge-out">OUT OF STOCK</span>`;
    if (status === "LOW STOCK") return `<span class="badge badge-low">LOW STOCK</span>`;
    return `<span class="badge badge-in">IN STOCK</span>`;
  }

  const inventoryRows = document.querySelectorAll("#inventoryTable tr");
  const lowStockTable = document.getElementById("lowStockTable");
  const alertList = document.getElementById("alertList");
  const criticalText = document.getElementById("criticalText");

  const sumTotal = document.getElementById("sumTotal");
  const sumLow = document.getElementById("sumLow");
  const sumOut = document.getElementById("sumOut");
  const sideLowBadge = document.getElementById("sideLowBadge");

  const restockModal = document.getElementById("restockModal");
  const modalSub = document.getElementById("modalSub");
  const qtyInput = document.getElementById("restockQty");
  const cancelBtn = document.getElementById("cancelRestock");
  const confirmBtn = document.getElementById("confirmRestock");

  let activeLowRow = null;
  let activeItemName = "";

  const historyTable = document.getElementById("historyTable");
  const historyEmpty = document.getElementById("historyEmpty");
  const clearHistoryBtn = document.getElementById("clearHistoryBtn");
  const HISTORY_KEY = "triad_restock_history";

  function loadHistory(){
    try{ return JSON.parse(localStorage.getItem(HISTORY_KEY)) || []; }
    catch(e){ return []; }
  }
  function saveHistory(list){ localStorage.setItem(HISTORY_KEY, JSON.stringify(list)); }

  function addHistory(entry){
    const list = loadHistory();
    list.unshift(entry);
    if (list.length > 200) list.length = 200;
    saveHistory(list);
    renderHistory();
  }

  function renderHistory(){
    historyTable.querySelectorAll("tr").forEach((tr, idx) => { if (idx !== 0) tr.remove(); });
    const list = loadHistory();
    if (!list.length){ historyEmpty.style.display = "block"; return; }
    historyEmpty.style.display = "none";

    list.forEach(h => {
      const tr = document.createElement("tr");
      tr.innerHTML = `<td>${h.datetime}</td><td>${h.product}</td><td>${h.added}</td><td>${h.from}</td><td>${h.to}</td>`;
      historyTable.appendChild(tr);
    });
  }

  clearHistoryBtn.addEventListener("click", () => {
    localStorage.removeItem(HISTORY_KEY);
    renderHistory();
  });

  function rebuildLowStock(){
    lowStockTable.querySelectorAll("tr").forEach((tr, idx) => { if (idx !== 0) tr.remove(); });
    alertList.innerHTML = "";

    let totalCritical = 0, lowCount = 0, outCount = 0;
    const outNames = [];

    inventoryRows.forEach((row) => {
      const cells = row.querySelectorAll("td");
      if (cells.length < 5) return;

      const itemName = cells[0].innerText.trim();
      const quantityText = cells[1].innerText.trim();
      const lastUpdated = cells[3].innerText.trim();

      const { num, unit } = parseQty(quantityText);
      const min = (MIN_LEVELS[itemName] != null) ? MIN_LEVELS[itemName] : 0;

      const computedStatus = statusFromStock(num, min);

      if (computedStatus === "LOW STOCK" || computedStatus === "OUT OF STOCK"){
        totalCritical++;
        if (computedStatus === "LOW STOCK") lowCount++;
        if (computedStatus === "OUT OF STOCK") { outCount++; outNames.push(itemName); }

        const tr = document.createElement("tr");
        tr.classList.add("lowstock-row");
        tr.dataset.product = itemName;
        tr.dataset.stock = String(num);
        tr.dataset.min = String(min);
        tr.dataset.unit = unit || "kg";
        tr.dataset.cat = CATEGORIES[itemName] || "others";

        if (computedStatus === "LOW STOCK") tr.classList.add("row-low");
        if (computedStatus === "OUT OF STOCK") tr.classList.add("row-out");

        tr.innerHTML = `
          <td>${itemName}</td>
          <td class="ls-stock">${num}${unit}</td>
          <td class="ls-min">${min}${unit}</td>
          <td class="ls-status">${badgeHTML(computedStatus)}</td>
          <td class="ls-updated">${lastUpdated || "-"}</td>
          <td><button class="btn-restock" type="button">Restock</button></td>
        `;
        lowStockTable.appendChild(tr);

        const li = document.createElement("li");
        li.innerText = `${itemName} – ${computedStatus === "LOW STOCK" ? "Low Stock" : "Out of Stock"}`;
        alertList.appendChild(li);
      }
    });

    sumTotal.textContent = String(Object.keys(MIN_LEVELS).length || (inventoryRows.length));
    sumLow.textContent = String(lowCount);
    sumOut.textContent = String(outCount);

    criticalText.innerText = totalCritical + " items critically low on stock!";

    const badgeVal = lowCount + outCount;
    if (badgeVal > 0){
      sideLowBadge.style.display = "inline-block";
      sideLowBadge.textContent = String(badgeVal);
    } else {
      sideLowBadge.style.display = "none";
    }

    localStorage.setItem("triad_out_of_stock", JSON.stringify(outNames));
  }

  const filterBtns = document.querySelectorAll(".low-filterBtn");
  function applyLowFilter(cat){
    const rows = document.querySelectorAll(".lowstock-row");
    rows.forEach(r => {
      const rowCat = r.dataset.cat || "others";
      r.style.display = (cat === "all" || rowCat === cat) ? "table-row" : "none";
    });
  }

  filterBtns.forEach(btn => {
    btn.addEventListener("click", () => {
      filterBtns.forEach(b => b.classList.remove("active"));
      btn.classList.add("active");
      applyLowFilter(btn.dataset.cat || "all");
    });
  });

  document.addEventListener("click", (e) => {
    const restockBtn = e.target.closest(".btn-restock");
    if (!restockBtn) return;

    const row = restockBtn.closest("tr");
    if (!row || !row.classList.contains("lowstock-row")) return;

    activeLowRow = row;
    activeItemName = row.dataset.product || "";

    qtyInput.value = "";
    modalSub.textContent = "Add quantity for: " + activeItemName;
    restockModal.classList.add("show");
    qtyInput.focus();
  });

  cancelBtn.addEventListener("click", () => {
    restockModal.classList.remove("show");
    activeLowRow = null;
    activeItemName = "";
  });

  confirmBtn.addEventListener("click", () => {
    if (!activeLowRow) return;

    const addQty = Number(qtyInput.value);
    if (!addQty || addQty <= 0) return;

    const unit = activeLowRow.dataset.unit || "kg";
    const min = Number(activeLowRow.dataset.min || 0);

    const current = Number(activeLowRow.dataset.stock || 0);
    const newStock = current + addQty;

    addHistory({
      datetime: nowText(),
      product: activeItemName,
      added: `${addQty}${unit}`,
      from: `${current}${unit}`,
      to: `${newStock}${unit}`
    });

    const invRows = Array.from(inventoryRows);
    const invRow = invRows.find(r => {
      const tds = r.querySelectorAll("td");
      return (tds[0] && tds[0].innerText.trim() === activeItemName);
    });

    if (invRow){
      const tds = invRow.querySelectorAll("td");
      tds[1].innerText = newStock + unit;
      tds[3].innerText = nowText();

      const computed = statusFromStock(newStock, min);
      if (computed === "IN STOCK"){
        tds[4].innerText = "Good";
        tds[4].className = "green";
        tds[4].style.color = "";
        tds[4].style.fontWeight = "";
      } else if (computed === "LOW STOCK"){
        tds[4].innerText = "Low Stock";
        tds[4].className = "";
        tds[4].style.color = "orange";
        tds[4].style.fontWeight = "bold";
      } else {
        tds[4].innerText = "Out of Stock";
        tds[4].className = "red";
        tds[4].style.color = "";
        tds[4].style.fontWeight = "";
      }
    }

    restockModal.classList.remove("show");
    activeLowRow = null;
    activeItemName = "";
    rebuildLowStock();
    applyInvFilter(); // ✅ update inventory view also
  });

  /* =======================
     CALENDAR (same as yours)
     ======================= */
  const calendarDays = document.querySelectorAll(".calendar-grid .day");
  const calendarModal = document.getElementById("calendarModal");
  const calendarDateText = document.getElementById("calendarDateText");
  const calendarInput = document.getElementById("calendarActivityInput");
  const calendarAdd = document.getElementById("calendarAdd");
  const calendarClose = document.getElementById("calendarClose");
  const calendarActivityList = document.getElementById("calendarActivityList");
  const allActivitiesList = document.getElementById("allActivitiesList");

  let selectedDate = "";
  const CAL_KEY = "triad_calendar_advanced";

  function getCalendarData(){
    try { return JSON.parse(localStorage.getItem(CAL_KEY) || "{}"); }
    catch(e){ return {}; }
  }
  function saveCalendarData(data){
    localStorage.setItem(CAL_KEY, JSON.stringify(data));
  }

  function renderCalendarDots(){
    const data = getCalendarData();

    calendarDays.forEach(day=>{
      day.querySelectorAll(".cal-dot").forEach(d=>d.remove());
      const date = day.dataset.date;
      if (data[date] && data[date].length){
        const dot = document.createElement("div");
        dot.className = "cal-dot";
        day.appendChild(dot);
      }
    });
  }

  function renderModalActivities(){
    const data = getCalendarData();
    calendarActivityList.innerHTML = "";

    const list = data[selectedDate] || [];
    if (!list.length){
      calendarActivityList.innerHTML = `<li style="color:#6b7280;">No activities</li>`;
      return;
    }

    list.forEach((activity,index)=>{
      const li = document.createElement("li");
      li.style.display = "flex";
      li.style.justifyContent = "space-between";
      li.style.alignItems = "center";
      li.style.gap = "10px";
      li.style.padding = "8px 10px";
      li.style.border = "1px solid #e5e7eb";
      li.style.borderRadius = "10px";
      li.style.marginBottom = "8px";
      li.innerHTML = `
        <span style="font-weight:800;color:#111827;">${activity}</span>
        <div style="display:flex; gap:8px;">
          <button type="button" onclick="editActivity('${selectedDate}', ${index})"
            style="border:1px solid #e5e7eb;background:#fff;border-radius:10px;padding:6px 10px;cursor:pointer;font-weight:900;">
            ✏
          </button>
          <button type="button" onclick="deleteActivity('${selectedDate}', ${index})"
            style="border:1px solid #e5e7eb;background:#fff;border-radius:10px;padding:6px 10px;cursor:pointer;font-weight:900;">
            🗑
          </button>
        </div>
      `;
      calendarActivityList.appendChild(li);
    });
  }

  function renderAllActivities(){
    const data = getCalendarData();
    allActivitiesList.innerHTML = "";

    const dates = Object.keys(data).sort();
    if (!dates.length){
      allActivitiesList.innerHTML = `<li style="color:#6b7280;">No scheduled activities yet.</li>`;
      return;
    }

    dates.forEach(date=>{
      data[date].forEach((activity)=>{
        const li = document.createElement("li");
        li.style.padding = "10px 12px";
        li.style.border = "1px solid #eef2f7";
        li.style.borderRadius = "12px";
        li.style.marginBottom = "10px";
        li.innerHTML = `<b style="color:#111827;">${date}</b> <span style="color:#6b7280;font-weight:800;">–</span> <span style="font-weight:900;color:#1e3a8a;">${activity}</span>`;
        allActivitiesList.appendChild(li);
      });
    });
  }

  calendarDays.forEach(day=>{
    day.addEventListener("click", ()=>{
      selectedDate = day.dataset.date;
      calendarDateText.textContent = "Selected date: " + selectedDate;
      calendarInput.value = "";
      calendarModal.classList.add("show");
      renderModalActivities();
    });
  });

  calendarAdd.addEventListener("click", ()=>{
    const activity = (calendarInput.value || "").trim();
    if (!activity || !selectedDate) return;

    const data = getCalendarData();
    if (!data[selectedDate]) data[selectedDate] = [];
    data[selectedDate].push(activity);

    saveCalendarData(data);
    calendarInput.value = "";
    renderModalActivities();
    renderCalendarDots();
    renderAllActivities();
  });

  calendarClose.addEventListener("click", ()=>{
    calendarModal.classList.remove("show");
    selectedDate = "";
  });

  window.editActivity = function(date, index){
    const data = getCalendarData();
    const current = (data[date] && data[date][index]) ? data[date][index] : "";
    const newValue = prompt("Edit activity:", current);
    if (newValue === null) return;

    const cleaned = newValue.trim();
    if (!cleaned) return;

    data[date][index] = cleaned;
    saveCalendarData(data);
    renderModalActivities();
    renderAllActivities();
    renderCalendarDots();
  };

  window.deleteActivity = function(date, index){
    const data = getCalendarData();
    if (!data[date]) return;

    data[date].splice(index, 1);
    if (data[date].length === 0) delete data[date];

    saveCalendarData(data);
    renderModalActivities();
    renderAllActivities();
    renderCalendarDots();
  };

  /* =======================
     SLIDESHOW (same)
     ======================= */
  (function(){
    const slider = document.getElementById("dashSlider");
    if(!slider) return;

    const imgs = Array.from(slider.querySelectorAll(".slide-img"));
    let idx = 0;
    let timer = null;

    function show(){
      imgs.forEach((im,i) => im.classList.toggle("active", i===idx));
    }
    function next(){ idx = (idx+1) % imgs.length; show(); }
    function start(){ timer = setInterval(next, 3500); }

    show();
    start();
  })();

  /* =======================
     CHARTS (DESIGN ONLY)
     ======================= */
  function fitCanvas(canvas){
    if(!canvas) return null;
    const box = canvas.parentElement;
    const rect = box.getBoundingClientRect();
    const dpr = window.devicePixelRatio || 1;

    canvas.width = Math.max(320, Math.floor(rect.width * dpr));
    canvas.height = Math.max(220, Math.floor(rect.height * dpr));
    canvas.style.width = rect.width + "px";
    canvas.style.height = rect.height + "px";

    const ctx = canvas.getContext("2d");
    ctx.setTransform(dpr,0,0,dpr,0,0);
    return ctx;
  }

  function drawGrid(ctx, w, h){
    ctx.clearRect(0,0,w,h);
    const pad = 28;
    const left = pad, top = 14, right = w - 14, bottom = h - pad;

    ctx.strokeStyle = "#e5e7eb";
    ctx.lineWidth = 1;

    for(let i=0;i<6;i++){
      const y = top + (i*(bottom-top)/5);
      ctx.beginPath(); ctx.moveTo(left, y); ctx.lineTo(right, y); ctx.stroke();
    }
    for(let i=0;i<8;i++){
      const x = left + (i*(right-left)/7);
      ctx.beginPath(); ctx.moveTo(x, top); ctx.lineTo(x, bottom); ctx.stroke();
    }

    ctx.strokeStyle = "#cbd5e1";
    ctx.beginPath();
    ctx.moveTo(left, top);
    ctx.lineTo(left, bottom);
    ctx.lineTo(right, bottom);
    ctx.stroke();
  }

  function drawBars(ctx, w, h, values, color){
    const pad = 28;
    const left = pad, top = 14, right = w - 14, bottom = h - pad;
    const maxV = Math.max(...values, 1);
    const gap = 10;
    const barW = ((right-left) - gap*(values.length-1)) / values.length;

    ctx.fillStyle = color;
    values.forEach((v,i)=>{
      const barH = (v/maxV) * (bottom-top);
      const x = left + i*(barW+gap);
      const y = bottom - barH;
      ctx.globalAlpha = 0.9;
      ctx.fillRect(x, y, barW, barH);
      ctx.globalAlpha = 1;
    });
  }

  function drawLine(ctx, w, h, values, color){
    const pad = 28;
    const left = pad, top = 14, right = w - 14, bottom = h - pad;
    const maxV = Math.max(...values, 1);

    ctx.strokeStyle = color;
    ctx.lineWidth = 3;
    ctx.beginPath();
    values.forEach((v,i)=>{
      const x = left + i*(right-left)/(values.length-1);
      const y = bottom - (v/maxV)*(bottom-top);
      if(i===0) ctx.moveTo(x,y); else ctx.lineTo(x,y);
    });
    ctx.stroke();

    ctx.fillStyle = color;
    values.forEach((v,i)=>{
      const x = left + i*(right-left)/(values.length-1);
      const y = bottom - (v/maxV)*(bottom-top);
      ctx.beginPath();
      ctx.arc(x,y,4,0,Math.PI*2);
      ctx.fill();
    });
  }

  function drawDaily(){
    const c = document.getElementById("dailyCanvas");
    const ctx = fitCanvas(c);
    if(!ctx) return;
    const w = c.parentElement.getBoundingClientRect().width;
    const h = c.parentElement.getBoundingClientRect().height;
    drawGrid(ctx, w, h);
    drawBars(ctx, w, h, [8, 12, 7, 15, 10, 18, 13], "#2563eb");
    drawLine(ctx, w, h, [5, 9, 6, 11, 9, 14, 10], "#22c55e");
  }

  function drawWeekly(){
    const c = document.getElementById("weeklyCanvas");
    const ctx = fitCanvas(c);
    if(!ctx) return;
    const w = c.parentElement.getBoundingClientRect().width;
    const h = c.parentElement.getBoundingClientRect().height;
    drawGrid(ctx, w, h);
    drawBars(ctx, w, h, [40, 55, 48, 70], "#2563eb");
    drawLine(ctx, w, h, [22, 30, 27, 38], "#22c55e");
  }

  function drawMonthly(){
    const c = document.getElementById("monthlyCanvas");
    const ctx = fitCanvas(c);
    if(!ctx) return;
    const w = c.parentElement.getBoundingClientRect().width;
    const h = c.parentElement.getBoundingClientRect().height;
    drawGrid(ctx, w, h);
    drawBars(ctx, w, h, [120, 150, 135, 160, 140, 175], "#2563eb");
    drawLine(ctx, w, h, [60, 72, 68, 80, 74, 90], "#22c55e");
  }

  function drawAllCharts(){ drawDaily(); drawWeekly(); drawMonthly(); }

  /* =======================
     ✅ INVENTORY FILTER FIXED
     ======================= */
  function invNorm(s){
    return (s || "").toLowerCase().replace(/\s+/g, " ").trim();
  }

  function getRowStatus(statusTd){
    if (!statusTd) return "";
    const txt = invNorm(statusTd.textContent);

    if (txt.includes("good")) return "good";
    if (txt.includes("low")) return "low stock";
    if (txt.includes("out")) return "out of stock";
    if (txt.includes("expired")) return "expired";

    if (statusTd.classList.contains("green")) return "good";
    if (statusTd.classList.contains("red")) return "out of stock";

    const color = invNorm(statusTd.style.color);
    if (color === "orange") return "low stock";

    return txt;
  }

  function applyInvFilter(){
  const invFilter = document.getElementById("inventoryFilter");
  const invSearch = document.getElementById("inventorySearch");
  const invTable = document.getElementById("inventoryTable");

  if (!invFilter || !invTable) return;

  const selected = (invFilter.value || "").toLowerCase().trim();
  const searchText = (invSearch ? invSearch.value : "").toLowerCase().trim();

  const rows = Array.from(invTable.querySelectorAll("tr"));

  rows.forEach((row) => {
    if (row.querySelector("th")) return; // skip header
    const tds = row.querySelectorAll("td");
    if (tds.length < 5) return;

    const name = (tds[0].textContent || "").toLowerCase();
    const status = getRowStatus(tds[4]);

    const matchStatus = (selected === "all") || (status === selected);
    const matchSearch = !searchText || name.includes(searchText);

    row.style.display = (matchStatus && matchSearch) ? "table-row" : "none";
  });
}

  // event delegation: works even after tab switches
  document.addEventListener("change", (e) => {
    if (e.target && e.target.id === "inventoryFilter") {
      applyInvFilter();
    }
  });
  document.addEventListener("input", (e) => {
  if (e.target && e.target.id === "inventorySearch") {
    applyInvFilter();
  }
});

  window.addEventListener("resize", drawAllCharts);

  /* INIT */
  rebuildLowStock();
  renderHistory();
  renderCalendarDots();
  renderAllActivities();
  drawAllCharts();
  applyInvFilter(); // run once

});


</script>
</script>

<!-- CREATE ACCOUNT MODAL -->
<div class="modal" id="createAccountModal">
  <div class="modal-box">
    <h3>Create Staff Account</h3>
    <p class="muted">Enter staff details below</p>

    <label>Full Name</label>
    <input type="text" id="newName" placeholder="e.g. Juan Dela Cruz">

    <label style="margin-top:10px;">Position</label>
    <input type="text" id="newPosition" placeholder="e.g. Barista">

    <label style="margin-top:10px;">Status</label>
    <select id="newStatus" style="width:100%;margin-top:6px;padding:10px;border-radius:10px;border:1px solid #ddd;font-weight:700;">
      <option value="online">Online</option>
      <option value="offline">Offline</option>
    </select>

    <div class="modal-actions">
      <button class="btn-ghost" id="cancelCreate">Cancel</button>
      <button class="btn-primary" id="saveCreate">Create</button>
    </div>
  </div>
</div>
</body>
</html>
