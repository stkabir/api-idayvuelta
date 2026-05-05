<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Guía de Usuario — Panel de Administración Booking Caribe</title>
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,600;1,300;1,400&family=Plus+Jakarta+Sans:wght@300;400;500;600&family=JetBrains+Mono:wght@400;500&display=swap" rel="stylesheet" />
  <style>
    :root {
      --cream:    #fffbf7;
      --navy:     #0f172a;
      --cyan:     #0891b2;
      --cyan-lt:  #e0f2fe;
      --cyan-dk:  #0c7ba1;
      --coral:    #f97316;
      --gold:     #f59e0b;
      --muted:    #64748b;
      --border:   #e2ddd8;
      --code-bg:  #0f172a;
      --sidebar-w: 280px;
      --green:    #10b981;
      --green-lt: #d1fae5;
      --red:      #ef4444;
      --red-lt:   #fee2e2;
    }

    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

    html { scroll-behavior: smooth; }

    body {
      font-family: 'Plus Jakarta Sans', sans-serif;
      background: var(--cream);
      color: var(--navy);
      font-size: 15px;
      line-height: 1.7;
      overflow-x: hidden;
    }

    body::before {
      content: '';
      position: fixed;
      inset: 0;
      pointer-events: none;
      z-index: 9999;
      opacity: .018;
      background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 512 512' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='n'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.75' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23n)'/%3E%3C/svg%3E");
    }

    .shell {
      display: flex;
      min-height: 100vh;
    }

    /* ── SIDEBAR ── */
    .sidebar {
      position: fixed;
      top: 0;
      left: 0;
      width: var(--sidebar-w);
      height: 100vh;
      background: var(--navy);
      overflow-y: auto;
      z-index: 100;
      display: flex;
      flex-direction: column;
      padding: 0 0 40px;
    }

    .sidebar::-webkit-scrollbar { width: 3px; }
    .sidebar::-webkit-scrollbar-track { background: transparent; }
    .sidebar::-webkit-scrollbar-thumb { background: rgba(255,255,255,.12); border-radius: 2px; }

    .sidebar-brand {
      padding: 28px 24px 20px;
      border-bottom: 1px solid rgba(255,255,255,.08);
      margin-bottom: 8px;
    }

    .sidebar-brand-logo {
      font-family: 'Cormorant Garamond', serif;
      font-size: 20px;
      font-weight: 600;
      color: #fff;
      letter-spacing: .02em;
      line-height: 1.2;
    }

    .sidebar-brand-logo span { color: var(--cyan); }

    .sidebar-brand-tag {
      margin-top: 6px;
      font-size: 10px;
      font-weight: 500;
      text-transform: uppercase;
      letter-spacing: .12em;
      color: rgba(255,255,255,.35);
    }

    .nav-section-label {
      padding: 14px 24px 5px;
      font-size: 9px;
      font-weight: 600;
      text-transform: uppercase;
      letter-spacing: .18em;
      color: rgba(255,255,255,.25);
    }

    .nav-link {
      display: flex;
      align-items: center;
      gap: 10px;
      padding: 8px 24px;
      color: rgba(255,255,255,.55);
      text-decoration: none;
      font-size: 13px;
      font-weight: 400;
      transition: color .2s, background .2s;
      border-left: 2px solid transparent;
    }

    .nav-link:hover {
      color: rgba(255,255,255,.9);
      background: rgba(255,255,255,.04);
    }

    .nav-link.active {
      color: var(--cyan);
      border-left-color: var(--cyan);
      background: rgba(8,145,178,.08);
    }

    .nav-link .dot {
      width: 5px;
      height: 5px;
      border-radius: 50%;
      background: currentColor;
      opacity: .5;
      flex-shrink: 0;
    }

    /* ── MAIN ── */
    .main {
      margin-left: var(--sidebar-w);
      flex: 1;
      min-width: 0;
    }

    /* ── HERO ── */
    .hero {
      position: relative;
      background: var(--navy);
      padding: 80px 72px 64px;
      overflow: hidden;
    }

    .hero::before {
      content: '';
      position: absolute;
      inset: 0;
      background:
        radial-gradient(ellipse 60% 80% at 85% 50%, rgba(8,145,178,.18) 0%, transparent 70%),
        radial-gradient(ellipse 40% 60% at 10% 80%, rgba(249,115,22,.1) 0%, transparent 60%);
    }

    .hero-tag {
      display: inline-flex;
      align-items: center;
      gap: 8px;
      background: rgba(8,145,178,.15);
      border: 1px solid rgba(8,145,178,.3);
      border-radius: 100px;
      padding: 5px 14px;
      font-size: 11px;
      font-weight: 500;
      letter-spacing: .1em;
      text-transform: uppercase;
      color: var(--cyan);
      margin-bottom: 28px;
      position: relative;
    }

    .hero-title {
      font-family: 'Cormorant Garamond', serif;
      font-size: clamp(36px, 4vw, 58px);
      font-weight: 300;
      line-height: 1.05;
      color: #fff;
      position: relative;
      margin-bottom: 16px;
    }

    .hero-title em {
      font-style: italic;
      color: var(--cyan);
    }

    .hero-subtitle {
      font-size: 15px;
      color: rgba(255,255,255,.5);
      font-weight: 300;
      max-width: 600px;
      position: relative;
      margin-bottom: 40px;
    }

    /* ── CONTENT ── */
    .content {
      padding: 0 72px 120px;
    }

    .section {
      padding-top: 64px;
    }

    .section-header {
      display: flex;
      align-items: baseline;
      gap: 16px;
      margin-bottom: 32px;
      padding-bottom: 16px;
      border-bottom: 1px solid var(--border);
    }

    .section-num {
      font-family: 'Cormorant Garamond', serif;
      font-size: 13px;
      color: var(--cyan);
      font-weight: 600;
      letter-spacing: .08em;
    }

    .section-title {
      font-family: 'Cormorant Garamond', serif;
      font-size: 28px;
      font-weight: 400;
      color: var(--navy);
      line-height: 1.1;
    }

    .section-title em {
      font-style: italic;
      color: var(--cyan);
    }

    /* ── INTRO TEXT ── */
    .intro-box {
      background: #fff;
      border: 1px solid var(--border);
      border-radius: 12px;
      padding: 28px 32px;
      margin-bottom: 32px;
      font-size: 14px;
      color: var(--muted);
      line-height: 1.8;
    }

    .intro-box strong { color: var(--navy); }

    /* ── IMPORTANT WARNING ── */
    .warning-box {
      background: #fff;
      border: 2px solid var(--coral);
      border-radius: 12px;
      padding: 28px 32px;
      margin-bottom: 32px;
      position: relative;
      overflow: hidden;
    }

    .warning-box::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      width: 4px;
      height: 100%;
      background: var(--coral);
    }

    .warning-icon {
      font-size: 28px;
      margin-bottom: 12px;
    }

    .warning-title {
      font-family: 'Cormorant Garamond', serif;
      font-size: 22px;
      font-weight: 600;
      color: var(--navy);
      margin-bottom: 10px;
    }

    .warning-text {
      font-size: 14px;
      color: var(--muted);
      line-height: 1.7;
    }

    .warning-text code {
      background: var(--cyan-lt);
      color: var(--cyan-dk);
      padding: 2px 7px;
      border-radius: 4px;
      font-family: 'JetBrains Mono', monospace;
      font-size: 12px;
    }

    /* ── LIMITATION LIST ── */
    .limit-list {
      display: flex;
      flex-direction: column;
      gap: 10px;
      margin-top: 16px;
    }

    .limit-item {
      display: flex;
      align-items: flex-start;
      gap: 12px;
      padding: 14px 18px;
      background: #fff;
      border: 1px solid var(--border);
      border-radius: 8px;
      font-size: 13.5px;
    }

    .limit-icon {
      font-size: 18px;
      flex-shrink: 0;
      margin-top: 1px;
    }

    .limit-text { color: var(--navy); line-height: 1.6; }
    .limit-text strong { font-weight: 600; }

    /* ── STEPS ── */
    .steps {
      display: flex;
      flex-direction: column;
      gap: 12px;
      margin-bottom: 32px;
    }

    .step {
      display: flex;
      align-items: flex-start;
      gap: 16px;
      padding: 20px 24px;
      background: #fff;
      border: 1px solid var(--border);
      border-radius: 10px;
    }

    .step-num {
      width: 32px;
      height: 32px;
      background: var(--cyan-lt);
      color: var(--cyan-dk);
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 13px;
      font-weight: 700;
      flex-shrink: 0;
    }

    .step-content { flex: 1; }

    .step-title {
      font-weight: 600;
      font-size: 14px;
      color: var(--navy);
      margin-bottom: 4px;
    }

    .step-desc {
      font-size: 13px;
      color: var(--muted);
      line-height: 1.6;
    }

    /* ── FIELD TABLE ── */
    .field-table {
      width: 100%;
      border-collapse: collapse;
      background: #fff;
      border: 1px solid var(--border);
      border-radius: 10px;
      overflow: hidden;
      margin-bottom: 28px;
      font-size: 13px;
    }

    .field-table thead tr {
      background: var(--navy);
      color: rgba(255,255,255,.7);
    }

    .field-table thead th {
      text-align: left;
      padding: 12px 18px;
      font-size: 10px;
      font-weight: 600;
      text-transform: uppercase;
      letter-spacing: .1em;
    }

    .field-table tbody tr {
      border-bottom: 1px solid var(--border);
    }

    .field-table tbody tr:last-child { border-bottom: none; }
    .field-table tbody tr:hover { background: rgba(8,145,178,.04); }

    .field-table td {
      padding: 13px 18px;
      vertical-align: middle;
    }

    .field-name {
      font-weight: 600;
      color: var(--navy);
      min-width: 140px;
    }

    .field-type {
      font-family: 'JetBrains Mono', monospace;
      font-size: 10.5px;
      background: #f1f5f9;
      color: var(--muted);
      padding: 2px 7px;
      border-radius: 4px;
      white-space: nowrap;
    }

    .field-desc {
      color: var(--muted);
      max-width: 360px;
    }

    .field-required {
      display: inline-flex;
      align-items: center;
      gap: 4px;
      font-size: 10px;
      font-weight: 600;
      text-transform: uppercase;
      letter-spacing: .06em;
      color: var(--coral);
      background: #fff1e9;
      padding: 2px 7px;
      border-radius: 4px;
    }

    .field-optional {
      font-size: 10px;
      font-weight: 600;
      text-transform: uppercase;
      letter-spacing: .06em;
      color: var(--green);
      background: var(--green-lt);
      padding: 2px 7px;
      border-radius: 4px;
    }

    .field-toggle {
      font-size: 10px;
      font-weight: 600;
      text-transform: uppercase;
      letter-spacing: .06em;
      color: var(--cyan-dk);
      background: var(--cyan-lt);
      padding: 2px 7px;
      border-radius: 4px;
    }

    /* ── SUBSECTION ── */
    .subsection {
      margin-bottom: 40px;
    }

    .subsection-title {
      font-family: 'Cormorant Garamond', serif;
      font-size: 22px;
      font-weight: 400;
      color: var(--navy);
      margin-bottom: 16px;
      padding-bottom: 10px;
      border-bottom: 1px solid var(--border);
    }

    .subsection-title em {
      font-style: italic;
      color: var(--cyan);
    }

    /* ── INFO BOX ── */
    .info-box {
      display: flex;
      gap: 14px;
      padding: 16px 20px;
      background: var(--cyan-lt);
      border: 1px solid rgba(8,145,178,.2);
      border-radius: 8px;
      margin-bottom: 20px;
      font-size: 13px;
      color: var(--cyan-dk);
    }

    .info-icon { font-size: 18px; flex-shrink: 0; margin-top: 1px; }

    /* ── DIVIDER ── */
    .divider {
      height: 1px;
      background: var(--border);
      margin: 40px 0;
    }

    /* ── RESPONSIVE ── */
    @media (max-width: 900px) {
      .sidebar { display: none; }
      .main { margin-left: 0; }
      .hero, .content { padding-left: 24px; padding-right: 24px; }
    }

    @media (max-width: 600px) {
      .hero-stats { flex-wrap: wrap; gap: 24px; }
    }
  </style>
</head>
<body>

<div class="shell">

  <!-- ═══════════════════════════════════════════
       SIDEBAR
  ════════════════════════════════════════════ -->
  <aside class="sidebar">
    <div class="sidebar-brand">
      <div class="sidebar-brand-logo">Booking<span>Caribe</span></div>
      <div class="sidebar-brand-tag">Guía de Usuario — Panel Admin</div>
    </div>

    <div class="nav-section-label">Guía</div>
    <a href="#introduccion" class="nav-link active"><span class="dot"></span>Introducción</a>
    <a href="#acceder" class="nav-link"><span class="dot"></span>Cómo acceder</a>
    <a href="#login" class="nav-link"><span class="dot"></span>Iniciar sesión</a>
    <a href="#hoteles" class="nav-link"><span class="dot"></span>Hoteles</a>
    <a href="#tours" class="nav-link"><span class="dot"></span>Tours</a>
    <a href="#traslados" class="nav-link"><span class="dot"></span>Traslados</a>
    <a href="#banners" class="nav-link"><span class="dot"></span>Banners</a>
    <a href="#reservas" class="nav-link"><span class="dot"></span>Reservas</a>
    <a href="#pagos" class="nav-link"><span class="dot"></span>Pagos</a>
    <a href="#promociones" class="nav-link"><span class="dot"></span>Promociones</a>
    <a href="#configuracion" class="nav-link"><span class="dot"></span>Configuración</a>
    <a href="#no-se-puede" class="nav-link"><span class="dot"></span>Lo que NO se puede hacer</a>
    <a href="#cerrar-sesion" class="nav-link"><span class="dot"></span>Cerrar sesión</a>
  </aside>

  <!-- ═══════════════════════════════════════════
       MAIN
  ════════════════════════════════════════════ -->
  <main class="main">

    <!-- HERO -->
    <div class="hero">
      <div class="hero-tag">Guía de Usuario</div>
      <h1 class="hero-title">Panel de<br><em>Administración</em></h1>
      <p class="hero-subtitle">
        Manual completo para gestionar tu plataforma de reservas de hoteles, tours y traslados en el Caribe Mexicano.
        Aprende a manejar cada sección del panel de control.
      </p>
    </div>

    <div class="content">

      <!-- ══════════════════════
           INTRODUCCIÓN
      ════════════════════════ -->
      <section class="section" id="introduccion">
        <div class="section-header">
          <span class="section-num">01</span>
          <h2 class="section-title">Introducción</h2>
        </div>

        <div class="intro-box">
          <p><strong>¿Qué es el panel de administración?</strong><br>
          Es el lugar desde donde tú administras todo el contenido de la plataforma web. Imagina que es como el "cuarto trasero" de una tienda física: desde ahí puedes colocar productos en los estantes (en este caso, hoteles, tours y traslados), ver los pedidos que llegan (reservas), cobrar el dinero (pagos) y cambiar los precios o la descripción de lo que vendes.</p>
          <br>
          <p><strong>¿Qué puedes hacer desde aquí?</strong></p>
          <ul style="margin-left: 20px; margin-top: 8px; display: flex; flex-direction: column; gap: 4px;">
            <li>✅ Agregar, editar y eliminar <strong>hoteles</strong></li>
            <li>✅ Agregar, editar y eliminar <strong>tours</strong> y <strong>excursiones</strong></li>
            <li>✅ Agregar, editar y eliminar <strong>traslados</strong> (servicios de transporte)</li>
            <li>✅ Gestionar las <strong>reservas</strong> de tus clientes</li>
            <li>✅ Revisar los <strong>pagos</strong> que entran</li>
            <li>✅ Crear <strong>promociones y códigos de descuento</strong></li>
            <li>✅ Cambiar la <strong>configuración general</strong> del sitio (colores, contacto, redes sociales)</li>
            <li>✅ Gestionar los <strong>banners</strong> (imágenes promocionales de la página principal)</li>
          </ul>
        </div>
      </section>

      <!-- ══════════════════════
           CÓMO ACCEDER
      ════════════════════════ -->
      <section class="section" id="acceder">
        <div class="section-header">
          <span class="section-num">02</span>
          <h2 class="section-title">Cómo <em>acceder</em> al panel</h2>
        </div>

        <div class="steps">
          <div class="step">
            <div class="step-num">1</div>
            <div class="step-content">
              <div class="step-title">Abre tu navegador web</div>
              <div class="step-desc">Abre Google Chrome, Mozilla Firefox, Microsoft Edge o Safari. El navegador es el programa que usas para entrar a internet (es donde ves las páginas web).</div>
            </div>
          </div>
          <div class="step">
            <div class="step-num">2</div>
            <div class="step-content">
              <div class="step-title">Escribe la dirección del panel</div>
              <div class="step-desc">En la barra de direcciones (la franja larga arriba donde dice qué página estás viendo), escribe exactamente:</div>
              <div style="margin-top: 10px; background: var(--code-bg); border-radius: 8px; padding: 12px 18px; font-family: 'JetBrains Mono', monospace; font-size: 13px; color: var(--cyan);">
                https://api.idayvueltamx.com/admin
              </div>
              <div class="step-desc" style="margin-top: 8px;">Si el sitio está en un servidor real (no en tu computadora), la dirección será algo como <code>https://api.idayvueltamx.com/admin</code> — pregúntale a quien te dio el acceso cuál es la dirección correcta.</div>
            </div>
          </div>
          <div class="step">
            <div class="step-num">3</div>
            <div class="step-content">
              <div class="step-title">Presiona Enter</div>
              <div class="step-desc">Después de escribir la dirección, presiona la tecla <strong>Enter</strong> (la tecla grande a la derecha del teclado) y la página del login aparecerá.</div>
            </div>
          </div>
        </div>

        <div class="info-box">
          <div class="info-icon">💡</div>
          <div><strong>Si no aparece nada:</strong> Puede que el servidor no esté encendido. Si estás trabajando en desarrollo, verifica que el comando <code>composer dev</code> o <code>php artisan serve</code> esté corriendo. Si es un servidor de producción, contacta al administrador.</div>
        </div>
      </section>

      <!-- ══════════════════════
           LOGIN
      ════════════════════════ -->
      <section class="section" id="login">
        <div class="section-header">
          <span class="section-num">03</span>
          <h2 class="section-title">Cómo <em>iniciar sesión</em></h2>
        </div>

        <div class="steps">
          <div class="step">
            <div class="step-num">1</div>
            <div class="step-content">
              <div class="step-title">Encuentra el campo "Email"</div>
              <div class="step-desc">En la página de login hay un campo que dice "Email" o "Correo electrónico". Ahí debes escribir tu correo de administrador. Las credenciales de prueba son:</div>
              <div style="margin-top: 10px; background: var(--code-bg); border-radius: 8px; padding: 12px 18px; font-family: 'JetBrains Mono', monospace; font-size: 13px; color: var(--cyan);">
                admin@booking.com
              </div>
            </div>
          </div>
          <div class="step">
            <div class="step-num">2</div>
            <div class="step-content">
              <div class="step-title">Escribe tu contraseña</div>
              <div class="step-desc">En el campo "Contraseña" (o "Password"), escribe la clave que te proporcionaron. Las credenciales de prueba son:</div>
              <div style="margin-top: 10px; background: var(--code-bg); border-radius: 8px; padding: 12px 18px; font-family: 'JetBrains Mono', monospace; font-size: 13px; color: var(--cyan);">
                password
              </div>
            </div>
          </div>
          <div class="step">
            <div class="step-num">3</div>
            <div class="step-content">
              <div class="step-title">Haz clic en "Recordarme" (opcional)</div>
              <div class="step-desc">Si quieres que el navegador recuerde tu sesión para no tener que iniciar sesión cada vez, marca la casilla "Recordarme". No lo uses en computadoras compartidas.</div>
            </div>
          </div>
          <div class="step">
            <div class="step-num">4</div>
            <div class="step-content">
              <div class="step-title">Haz clic en el botón de iniciar sesión</div>
              <div class="step-desc">Busca el botón que dice "Iniciar sesión", "Entrar" o "Login" y haz clic en él. Si todo está bien, entrarás al panel de administración.</div>
            </div>
          </div>
        </div>

        <div class="info-box">
          <div class="info-icon">🔑</div>
          <div><strong>Credenciales de acceso (ejemplo):</strong><br>
          Email: <code>admin@booking.com</code><br>
          Contraseña: <code>password</code><br><br>
          Si no funcionan, es posible que alguien las haya cambiado. Consulta con el desarrollador del sistema.</div>
        </div>
      </section>

      <div class="divider"></div>

      <!-- ══════════════════════
           HOTELES
      ════════════════════════ -->
      <section class="section" id="hoteles">
        <div class="section-header">
          <span class="section-num">04</span>
          <h2 class="section-title">Hoteles</h2>
        </div>

        <div class="intro-box" style="margin-bottom: 24px;">
          La sección de <strong>Hoteles</strong> es donde gestionas todos los establecimientos de alojamiento que ofreces en tu plataforma. Cada registro representa un hotel, resort o cualquier otro tipo de hospedaje.
        </div>

        <div class="subsection">
          <h3 class="subsection-title">Cómo <em>crear</em> un hotel nuevo</h3>

          <div class="steps">
            <div class="step">
              <div class="step-num">1</div>
              <div class="step-content">
                <div class="step-title">Ve al menú lateral y haz clic en "Hotels"</div>
                <div class="step-desc">En el menú de la izquierda, busca la opción que dice "Hotels" y haz clic en ella. Verás la lista de hoteles existentes.</div>
              </div>
            </div>
            <div class="step">
              <div class="step-num">2</div>
              <div class="step-content">
                <div class="step-title">Haz clic en "New Hotel" o "Nuevo Hotel"</div>
                <div class="step-desc">Buscar un botón grande que generalmente aparece arriba a la derecha de la lista. El texto puede ser "New Hotel", "Agregar" o tener un ícono de + (más).</div>
              </div>
            </div>
            <div class="step">
              <div class="step-num">3</div>
              <div class="step-content">
                <div class="step-title">Rellena todos los campos del formulario</div>
                <div class="step-desc">El formulario tiene varios campos. Abajo te explicamos qué significa cada uno.</div>
              </div>
            </div>
            <div class="step">
              <div class="step-num">4</div>
              <div class="step-content">
                <div class="step-title">Sube las imágenes del hotel</div>
                <div class="step-desc">Busca la sección de "Images" o "Imágenes" y arrastra fotos desde tu computadora o haz clic para seleccionarlas. Debes incluir al menos una foto de portada.</div>
              </div>
            </div>
            <div class="step">
              <div class="step-num">5</div>
              <div class="step-content">
                <div class="step-title">Haz clic en "Guardar" o "Save"</div>
                <div class="step-desc">Cuando termines de llenar todos los campos, busca el botón para guardar. El hotel aparecerá en la lista.</div>
              </div>
            </div>
          </div>
        </div>

        <div class="subsection">
          <h3 class="subsection-title">Campos del <em>formulario</em> de hotel</h3>

          <table class="field-table">
            <thead>
              <tr>
                <th>Campo</th>
                <th>Tipo</th>
                <th>Descripción</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td><span class="field-name">Name (Nombre)</span></td>
                <td><span class="field-required">Obligatorio</span></td>
                <td><span class="field-desc">El nombre oficial del hotel, tal como quieres que aparezca en la página web. Ejemplo: "Hotel Playa del Carmen Beach Resort"</span></td>
              </tr>
              <tr>
                <td><span class="field-name">Slug</span></td>
                <td><span class="field-required">Obligatorio</span></td>
                <td><span class="field-desc">Es la versión de la URL del nombre: sin acentos, sin espacios (los espacios se reemplazan por guiones "-"). Ejemplo: "playa-del-carmen-beach-resort". Este campo se usa para que la dirección del hotel sea limpia y legible.</span></td>
              </tr>
              <tr>
                <td><span class="field-name">Description</span></td>
                <td><span class="field-optional">Opcional</span></td>
                <td><span class="field-desc">Descripción larga del hotel que aparece en la página de detalle. Cuéntale al cliente por qué debería elegir este hotel.</span></td>
              </tr>
              <tr>
                <td><span class="field-name">Address</span></td>
                <td><span class="field-optional">Opcional</span></td>
                <td><span class="field-desc">La dirección física completa del hotel: calle, número, colonia, etc.</span></td>
              </tr>
              <tr>
                <td><span class="field-name">City (Ciudad)</span></td>
                <td><span class="field-required">Obligatorio</span></td>
                <td><span class="field-desc">La ciudad donde está ubicado el hotel. Ejemplo: "Playa del Carmen", "Cancún", "Tulum".</span></td>
              </tr>
              <tr>
                <td><span class="field-name">State</span></td>
                <td><span class="field-optional">Opcional</span></td>
                <td><span class="field-desc">El estado o región. Ejemplo: "Quintana Roo", "Yucatán".</span></td>
              </tr>
              <tr>
                <td><span class="field-name">Country</span></td>
                <td><span class="field-optional">Opcional</span></td>
                <td><span class="field-desc">El país. Por defecto viene "Mexico".</span></td>
              </tr>
              <tr>
                <td><span class="field-name">Stars</span></td>
                <td><span class="field-optional">Opcional</span></td>
                <td><span class="field-desc">La categoría en estrellas del hotel (1 a 5). Generalmente es la categoría oficial que le da el gobierno turístico.</span></td>
              </tr>
              <tr>
                <td><span class="field-name">Price per Night</span></td>
                <td><span class="field-required">Obligatorio</span></td>
                <td><span class="field-desc">El precio base por noche, en pesos mexicanos (MXN). Este es el precio que se muestra en la página web.</span></td>
              </tr>
              <tr>
                <td><span class="field-name">Amenities</span></td>
                <td><span class="field-optional">Opcional</span></td>
                <td><span class="field-desc">Los servicios que incluye el hotel, separados por comas. Ejemplo: "Wi-Fi, Piscina, Spa, Restaurante, Bar, Gym".</span></td>
              </tr>
              <tr>
                <td><span class="field-name">Is Active</span></td>
                <td><span class="field-toggle">Interruptor</span></td>
                <td><span class="field-desc">Cuando está ОК (encendido), el hotel aparece en la página web. Cuando está apagado, desaparece de la web pero sigue en la base de datos.</span></td>
              </tr>
              <tr>
                <td><span class="field-name">Featured</span></td>
                <td><span class="field-toggle">Interruptor</span></td>
                <td><span class="field-desc">Los hoteles marcados como "featured" aparecen en secciones destacadas de la página de inicio o en listados prioritarios.</span></td>
              </tr>
              <tr>
                <td><span class="field-name">Latitude / Longitude</span></td>
                <td><span class="field-optional">Opcional</span></td>
                <td><span class="field-desc">Coordenadas geográficas para mostrar el hotel en un mapa. Puedes obtenerlas de Google Maps.</span></td>
              </tr>
              <tr>
                <td><span class="field-name">Images</span></td>
                <td><span class="field-optional">Imágenes</span></td>
                <td><span class="field-desc">Fotos del hotel. La primera imagen se usa como foto de portada. Puedes agregar varias fotos para que los clientes vean diferentes áreas del hotel.</span></td>
              </tr>
            </tbody>
          </table>
        </div>

        <div class="subsection">
          <h3 class="subsection-title">Cómo <em>editar</em> un hotel</h3>
          <div class="steps">
            <div class="step">
              <div class="step-num">1</div>
              <div class="step-content">
                <div class="step-title">Ve a la lista de hoteles</div>
                <div class="step-desc">Haz clic en "Hotels" en el menú lateral.</div>
              </div>
            </div>
            <div class="step">
              <div class="step-num">2</div>
              <div class="step-content">
                <div class="step-title">Busca el hotel que quieres cambiar</div>
                <div class="step-desc">Puedes buscar por nombre usando el cuadro de búsqueda o desplazarte por la lista.</div>
              </div>
            </div>
            <div class="step">
              <div class="step-num">3</div>
              <div class="step-content">
                <div class="step-title">Haz clic en la fila del hotel</div>
                <div class="step-desc">Generalmente se hace clic en el texto del hotel o en un botón de lápiz que aparece al pasar el mouse sobre la fila.</div>
              </div>
            </div>
            <div class="step">
              <div class="step-num">4</div>
              <div class="step-content">
                <div class="step-title">Modifica los campos necesarios y guarda</div>
                <div class="step-desc">Cambia lo que necesites y haz clic en "Guardar" o "Save".</div>
              </div>
            </div>
          </div>
        </div>

        <div class="subsection">
          <h3 class="subsection-title">Cómo <em>eliminar</em> un hotel</h3>
          <div class="info-box">
            <div class="info-icon">⚠️</div>
            <div>Antes de eliminar un hotel, verifica que no tenga reservas activas asociadas. Si eliminas un hotel con reservas, esas reservas seguirán existiendo pero no tendrán el hotel asociado, lo cual puede causar confusión. Considera mejor desactivar el hotel (toggle "Is Active") en lugar de eliminarlo.</div>
          </div>
          <div class="steps">
            <div class="step">
              <div class="step-num">1</div>
              <div class="step-content">
                <div class="step-title">Ve a la lista de hoteles y abre el hotel a eliminar</div>
                <div class="step-desc">Abre el formulario de edición del hotel.</div>
              </div>
            </div>
            <div class="step">
              <div class="step-num">2</div>
              <div class="step-content">
                <div class="step-title">Busca el botón "Delete" o "Eliminar"</div>
                <div class="step-desc">Generalmente aparece en la parte superior del formulario, a veces de color rojo o con un ícono de papelera.</div>
              </div>
            </div>
            <div class="step">
              <div class="step-num">3</div>
              <div class="step-content">
                <div class="step-title">Confirma la eliminación</div>
                <div class="step-desc">El sistema te preguntará si estás seguro. Haz clic en "Sí, eliminar" o "Confirm". Esta acción no se puede deshacer.</div>
              </div>
            </div>
          </div>
        </div>
      </section>

      <div class="divider"></div>

      <!-- ══════════════════════
           TOURS
      ════════════════════════ -->
      <section class="section" id="tours">
        <div class="section-header">
          <span class="section-num">05</span>
          <h2 class="section-title">Tours y <em>Excursiones</em></h2>
        </div>

        <div class="intro-box" style="margin-bottom: 24px;">
          La sección de <strong>Tours</strong> te permite gestionar todas las experiencias, excursiones y actividades turísticas que ofreces. Cada tour puede incluir transporte, guía, comida y más.
        </div>

        <div class="subsection">
          <h3 class="subsection-title">Campos del <em>formulario</em> de tour</h3>

          <table class="field-table">
            <thead>
              <tr>
                <th>Campo</th>
                <th>Tipo</th>
                <th>Descripción</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td><span class="field-name">Name</span></td>
                <td><span class="field-required">Obligatorio</span></td>
                <td><span class="field-desc">El nombre del tour como aparece en la página web. Ejemplo: "Tour a Chichén Itzá".</span></td>
              </tr>
              <tr>
                <td><span class="field-name">Slug</span></td>
                <td><span class="field-required">Obligatorio</span></td>
                <td><span class="field-desc">Versión limpia del nombre para la URL. Ejemplo: "tour-chichen-itza".</span></td>
              </tr>
              <tr>
                <td><span class="field-name">Description</span></td>
                <td><span class="field-optional">Opcional</span></td>
                <td><span class="field-desc">Descripción general del tour que lee el cliente.</span></td>
              </tr>
              <tr>
                <td><span class="field-name">Highlights</span></td>
                <td><span class="field-optional">Opcional</span></td>
                <td><span class="field-desc">Los puntos más importantes o atractivos del tour. Ejemplo: "Pirámide de Kukulkán, Cenote Sagrado, Juego de Pelota".</span></td>
              </tr>
              <tr>
                <td><span class="field-name">Destination</span></td>
                <td><span class="field-required">Obligatorio</span></td>
                <td><span class="field-desc">El destino principal del tour. Ejemplo: "Chichén Itzá", "Cozumel", "Tulum".</span></td>
              </tr>
              <tr>
                <td><span class="field-name">Duration</span></td>
                <td><span class="field-required">Obligatorio</span></td>
                <td><span class="field-desc">La duración total del tour. Ejemplo: "Full Day (12 horas)", "6 horas", "Medio día (4 horas)".</span></td>
              </tr>
              <tr>
                <td><span class="field-name">Max People</span></td>
                <td><span class="field-optional">Opcional</span></td>
                <td><span class="field-desc">El número máximo de personas que pueden participar en un mismo grupo. Ejemplo: "40".</span></td>
              </tr>
              <tr>
                <td><span class="field-name">Price Adult</span></td>
                <td><span class="field-required">Obligatorio</span></td>
                <td><span class="field-desc">Precio por persona adulta, en pesos mexicanos (MXN).</span></td>
              </tr>
              <tr>
                <td><span class="field-name">Price Child</span></td>
                <td><span class="field-optional">Opcional</span></td>
                <td><span class="field-desc">Precio para niños (generalmente menores de 12 años). Si no quieres ofrecer precio infantil, puedes dejarlo vacío.</span></td>
              </tr>
              <tr>
                <td><span class="field-name">Included</span></td>
                <td><span class="field-optional">Opcional</span></td>
                <td><span class="field-desc">Qué incluye el tour, separado por comas. Ejemplo: "Transporte, Guía, Entrada, Comida".</span></td>
              </tr>
              <tr>
                <td><span class="field-name">Not Included</span></td>
                <td><span class="field-optional">Opcional</span></td>
                <td><span class="field-desc">Qué NO incluye el tour. Ejemplo: "Bebidas, Propinas".</span></td>
              </tr>
              <tr>
                <td><span class="field-name">Meeting Point</span></td>
                <td><span class="field-optional">Opcional</span></td>
                <td><span class="field-desc">Dónde se encuentran los participantes. Ejemplo: "Hotel pickup" (recogida en el hotel) o una dirección específica.</span></td>
              </tr>
              <tr>
                <td><span class="field-name">Itinerary</span></td>
                <td><span class="field-optional">Opcional</span></td>
                <td><span class="field-desc">El programa detallado del tour, paso a paso. Ejemplo: "6:00 AM - Recogida en hotel, 7:30 AM - Llegada a Chichén Itzá..."</span></td>
              </tr>
              <tr>
                <td><span class="field-name">Difficulty Level</span></td>
                <td><span class="field-optional">Opcional</span></td>
                <td><span class="field-desc">Nivel de dificultad física: "easy" (fácil), "moderate" (moderado), "difficult" (difícil). Puede servir para que los clientes evalúen si el tour es adecuado para ellos.</span></td>
              </tr>
              <tr>
                <td><span class="field-name">Is Active</span></td>
                <td><span class="field-toggle">Interruptor</span></td>
                <td><span class="field-desc">Si está apagado, el tour no aparece en la página web.</span></td>
              </tr>
              <tr>
                <td><span class="field-name">Featured</span></td>
                <td><span class="field-toggle">Interruptor</span></td>
                <td><span class="field-desc">Los tours destacados aparecen en secciones especiales de la página de inicio.</span></td>
              </tr>
              <tr>
                <td><span class="field-name">Images</span></td>
                <td><span class="field-optional">Imágenes</span></td>
                <td><span class="field-desc">Fotos del tour. La primera foto se usa como imagen de portada.</span></td>
              </tr>
            </tbody>
          </table>
        </div>
      </section>

      <div class="divider"></div>

      <!-- ══════════════════════
           TRASLADOS
      ════════════════════════ -->
      <section class="section" id="traslados">
        <div class="section-header">
          <span class="section-num">06</span>
          <h2 class="section-title">Traslados</h2>
        </div>

        <div class="intro-box" style="margin-bottom: 24px;">
          La sección de <strong>Traslados</strong> gestiona los servicios de transporte, ya sea del aeropuerto a los hoteles o entre cualesquiera dos ubicaciones. Puede ser privado (solo para ti) o compartido con otros pasajeros.
        </div>

        <div class="subsection">
          <h3 class="subsection-title">Campos del <em>formulario</em> de traslado</h3>

          <table class="field-table">
            <thead>
              <tr>
                <th>Campo</th>
                <th>Tipo</th>
                <th>Descripción</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td><span class="field-name">Name</span></td>
                <td><span class="field-required">Obligatorio</span></td>
                <td><span class="field-desc">Nombre del servicio. Ejemplo: "Transfer Aeropuerto - Playa del Carmen".</span></td>
              </tr>
              <tr>
                <td><span class="field-name">Slug</span></td>
                <td><span class="field-required">Obligatorio</span></td>
                <td><span class="field-desc">Versión limpia del nombre para la URL. Ejemplo: "transfer-airport-playa-del-carmen".</span></td>
              </tr>
              <tr>
                <td><span class="field-name">Description</span></td>
                <td><span class="field-optional">Opcional</span></td>
                <td><span class="field-desc">Descripción del servicio de transporte.</span></td>
              </tr>
              <tr>
                <td><span class="field-name">From Location</span></td>
                <td><span class="field-required">Obligatorio</span></td>
                <td><span class="field-desc">Punto de origen. Ejemplo: "Aeropuerto de Cancún".</span></td>
              </tr>
              <tr>
                <td><span class="field-name">To Location</span></td>
                <td><span class="field-required">Obligatorio</span></td>
                <td><span class="field-desc">Punto de destino. Ejemplo: "Playa del Carmen".</span></td>
              </tr>
              <tr>
                <td><span class="field-name">Type</span></td>
                <td><span class="field-required">Obligatorio</span></td>
                <td><span class="field-desc">Tipo de viaje: "one-way" (solo ida) o "round-trip" (ida y vuelta).</span></td>
              </tr>
              <tr>
                <td><span class="field-name">Vehicle Type</span></td>
                <td><span class="field-required">Obligatorio</span></td>
                <td><span class="field-desc">Tipo de vehículo: "sedan" (auto normal), "van" (vans), "bus" (autobús), etc.</span></td>
              </tr>
              <tr>
                <td><span class="field-name">Max Passengers</span></td>
                <td><span class="field-required">Obligatorio</span></td>
                <td><span class="field-desc">Cantidad máxima de pasajeros que caben en el vehículo. Ejemplo: "4" para un sedan, "12" para una van.</span></td>
              </tr>
              <tr>
                <td><span class="field-name">Price</span></td>
                <td><span class="field-required">Obligatorio</span></td>
                <td><span class="field-desc">Precio del servicio en pesos mexicanos (MXN).</span></td>
              </tr>
              <tr>
                <td><span class="field-name">Is Private</span></td>
                <td><span class="field-toggle">Interruptor</span></td>
                <td><span class="field-desc">Si está encendido, es un servicio privado (solo el cliente y su grupo). Si está apagado, es un servicio compartido.</span></td>
              </tr>
              <tr>
                <td><span class="field-name">Features</span></td>
                <td><span class="field-optional">Opcional</span></td>
                <td><span class="field-desc">Características del vehículo, separadas por comas. Ejemplo: "Aire acondicionado, Wi-Fi, Agua embotellada".</span></td>
              </tr>
              <tr>
                <td><span class="field-name">Is Active</span></td>
                <td><span class="field-toggle">Interruptor</span></td>
                <td><span class="field-desc">Si está apagado, el traslado no aparece en la página web.</span></td>
              </tr>
              <tr>
                <td><span class="field-name">Featured</span></td>
                <td><span class="field-toggle">Interruptor</span></td>
                <td><span class="field-desc">Los traslados destacados aparecen en secciones especiales.</span></td>
              </tr>
              <tr>
                <td><span class="field-name">Images</span></td>
                <td><span class="field-optional">Imágenes</span></td>
                <td><span class="field-desc">Fotos del vehículo o del servicio.</span></td>
              </tr>
            </tbody>
          </table>
        </div>
      </section>

      <div class="divider"></div>

      <!-- ══════════════════════
           BANNERS
      ════════════════════════ -->
      <section class="section" id="banners">
        <div class="section-header">
          <span class="section-num">07</span>
          <h2 class="section-title">Banners</h2>
        </div>

        <div class="intro-box" style="margin-bottom: 24px;">
          Los <strong>Banners</strong> son las imágenes grandes que aparecen en la página de inicio de tu sitio web. Generalmente son imágenes de fondo con texto superpuesto que invitan al usuario a explorar hoteles, tours o traslados. Puedes tener varios banners y definir en qué orden aparecen.
        </div>

        <div class="subsection">
          <h3 class="subsection-title">Campos del <em>formulario</em> de banner</h3>

          <table class="field-table">
            <thead>
              <tr>
                <th>Campo</th>
                <th>Tipo</th>
                <th>Descripción</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td><span class="field-name">Title</span></td>
                <td><span class="field-required">Obligatorio</span></td>
                <td><span class="field-desc">El título principal que aparece sobre la imagen. Ejemplo: "Descubre el Caribe Mexicano".</span></td>
              </tr>
              <tr>
                <td><span class="field-name">Subtitle</span></td>
                <td><span class="field-optional">Opcional</span></td>
                <td><span class="field-desc">Un subtítulo más pequeño debajo del título. Ejemplo: "Las mejores experiencias te esperan".</span></td>
              </tr>
              <tr>
                <td><span class="field-name">Description</span></td>
                <td><span class="field-optional">Opcional</span></td>
                <td><span class="field-desc">Una descripción breve que puede aparecer junto con el título.</span></td>
              </tr>
              <tr>
                <td><span class="field-name">Button Text</span></td>
                <td><span class="field-optional">Opcional</span></td>
                <td><span class="field-desc">El texto que aparece en el botón. Ejemplo: "Ver Tours", "Reservar ahora".</span></td>
              </tr>
              <tr>
                <td><span class="field-name">Button URL</span></td>
                <td><span class="field-optional">Opcional</span></td>
                <td><span class="field-desc">La dirección web a la que lleva el botón cuando el usuario hace clic. Ejemplo: "/tours" (para ir a la página de tours) o "/hotels" (para ir a la página de hoteles).</span></td>
              </tr>
              <tr>
                <td><span class="field-name">Position</span></td>
                <td><span class="field-optional">Opcional</span></td>
                <td><span class="field-desc">La posición del banner en el carrusel. Por ejemplo "home" significa que aparece en la página de inicio.</span></td>
              </tr>
              <tr>
                <td><span class="field-name">Order</span></td>
                <td><span class="field-optional">Opcional</span></td>
                <td><span class="field-desc">El orden de aparición. El número más bajo aparece primero. Ejemplo: 1, 2, 3.</span></td>
              </tr>
              <tr>
                <td><span class="field-name">Is Active</span></td>
                <td><span class="field-toggle">Interruptor</span></td>
                <td><span class="field-desc">Si está apagado, el banner no se muestra en la página web.</span></td>
              </tr>
              <tr>
                <td><span class="field-name">Image</span></td>
                <td><span class="field-required">Obligatorio</span></td>
                <td><span class="field-desc">La imagen de fondo del banner. Debe ser una imagen grande y de buena calidad (se recomienda al menos 1920px de ancho).</span></td>
              </tr>
            </tbody>
          </table>
        </div>
      </section>

      <div class="divider"></div>

      <!-- ══════════════════════
           RESERVAS
      ════════════════════════ -->
      <section class="section" id="reservas">
        <div class="section-header">
          <span class="section-num">08</span>
          <h2 class="section-title">Reservas</h2>
        </div>

        <div class="intro-box" style="margin-bottom: 24px;">
          La sección de <strong>Reservas</strong> muestra todos los bookings que hacen los clientes desde la página web. Aquí puedes ver los detalles de cada reserva, cambiar su estado y agregar notas internas.
        </div>

        <div class="subsection">
          <h3 class="subsection-title">Campos de una <em>reserva</em></h3>

          <table class="field-table">
            <thead>
              <tr>
                <th>Campo</th>
                <th>Descripción</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td><span class="field-name">Booking Number</span></td>
                <td><span class="field-desc">El número único de reserva. Es el identificador que se le da al cliente para rastrear su reserva. Ejemplo: "RSV-2026-0042".</span></td>
              </tr>
              <tr>
                <td><span class="field-name">Customer Name</span></td>
                <td><span class="field-desc">El nombre completo del cliente que hizo la reserva.</span></td>
              </tr>
              <tr>
                <td><span class="field-name">Customer Email</span></td>
                <td><span class="field-desc">El correo electrónico del cliente. Aquí se le enviaría un email de confirmación (actualmente no implementado).</span></td>
              </tr>
              <tr>
                <td><span class="field-name">Customer Phone</span></td>
                <td><span class="field-desc">El teléfono del cliente. Puede tener código de país. Ejemplo: "+52 998 123 4567".</span></td>
              </tr>
              <tr>
                <td><span class="field-name">Bookable</span></td>
                <td><span class="field-desc">A qué servicio está asociada la reserva: un Hotel, un Tour o un Transfer. También muestra el nombre específico de ese servicio.</span></td>
              </tr>
              <tr>
                <td><span class="field-name">Start Date</span></td>
                <td><span class="field-desc">La fecha de inicio de la reserva (check-in para hoteles, fecha del tour, fecha de salida del traslado).</span></td>
              </tr>
              <tr>
                <td><span class="field-name">End Date</span></td>
                <td><span class="field-desc">La fecha de fin (check-out para hoteles). Para tours de un día puede estar vacía.</span></td>
              </tr>
              <tr>
                <td><span class="field-name">Pickup Time</span></td>
                <td><span class="field-desc">La hora de recogida acordada (para tours y traslados).</span></td>
              </tr>
              <tr>
                <td><span class="field-name">Adults</span></td>
                <td><span class="field-desc">Número de adultos en la reserva.</span></td>
              </tr>
              <tr>
                <td><span class="field-name">Children</span></td>
                <td><span class="field-desc">Número de niños en la reserva.</span></td>
              </tr>
              <tr>
                <td><span class="field-name">Subtotal</span></td>
                <td><span class="field-desc">El subtotal antes de impuestos y descuentos.</span></td>
              </tr>
              <tr>
                <td><span class="field-name">Discount</span></td>
                <td><span class="field-desc">El monto de descuento aplicado si se usó un código promocional.</span></td>
              </tr>
              <tr>
                <td><span class="field-name">Tax</span></td>
                <td><span class="field-desc">Los impuestos aplicados a la reserva.</span></td>
              </tr>
              <tr>
                <td><span class="field-name">Total</span></td>
                <td><span class="field-desc">El monto total a pagar (después de descuentos e impuestos).</span></td>
              </tr>
              <tr>
                <td><span class="field-name">Status</span></td>
                <td><span class="field-desc">El estado de la reserva: <strong>pending</strong> (pendiente), <strong>confirmed</strong> (confirmada), <strong>cancelled</strong> (cancelada). Puedes cambiarlo manualmente.</span></td>
              </tr>
              <tr>
                <td><span class="field-name">Payment Status</span></td>
                <td><span class="field-desc">El estado del pago: <strong>pending</strong> (pendiente de pago), <strong>paid</strong> (pagado), <strong>failed</strong> (falló), <strong>refunded</strong> (reembolsado).</span></td>
              </tr>
              <tr>
                <td><span class="field-name">Payment Method</span></td>
                <td><span class="field-desc">El método de pago utilizado: tarjeta de crédito, débito, transferencia, etc.</span></td>
              </tr>
              <tr>
                <td><span class="field-name">Payment ID</span></td>
                <td><span class="field-desc">El identificador que da OpenPay (la plataforma de pagos) para esta transacción.</span></td>
              </tr>
              <tr>
                <td><span class="field-name">Special Requests</span></td>
                <td><span class="field-desc">Las notas o solicitudes especiales que escribió el cliente al hacer la reserva. Ejemplo: "Necesito cuna para bebé", "Llegaré tarde al hotel".</span></td>
              </tr>
              <tr>
                <td><span class="field-name">Admin Notes</span></td>
                <td><span class="field-desc">Notas internas que solo tú y otros administradores pueden ver. Sirve para comunicar información importante sobre la reserva entre miembros del equipo.</span></td>
              </tr>
            </tbody>
          </table>
        </div>

        <div class="subsection">
          <h3 class="subsection-title">Gestión de <em>reservas</em></h3>

          <div class="steps">
            <div class="step">
              <div class="step-num">📋</div>
              <div class="step-content">
                <div class="step-title">Ver la lista de reservas</div>
                <div class="step-desc">Ve a "Bookings" en el menú lateral. Verás una lista con todas las reservas ordenadas de la más reciente a la más antigua.</div>
              </div>
            </div>
            <div class="step">
              <div class="step-num">🔍</div>
              <div class="step-content">
                <div class="step-title">Ver detalles de una reserva</div>
                <div class="step-desc">Haz clic en el número de reserva o en el botón de ver (generalmente un ícono de ojo 👁️) para abrir los detalles completos.</div>
              </div>
            </div>
            <div class="step">
              <div class="step-num">✏️</div>
              <div class="step-content">
                <div class="step-title">Editar una reserva</div>
                <div class="step-desc">Para cambiar información de la reserva (fecha, número de personas, notas), abre la reserva y busca el botón de editar. Recuerda guardar los cambios.</div>
              </div>
            </div>
            <div class="step">
              <div class="step-num">📝</div>
              <div class="step-content">
                <div class="step-title">Agregar notas internas</div>
                <div class="step-desc">Abre la reserva, ve al campo "Admin Notes" y escribe cualquier información relevante. Estas notas solo las ven los administradores, no el cliente.</div>
              </div>
            </div>
            <div class="step">
              <div class="step-num">🔄</div>
              <div class="step-content">
                <div class="step-title">Cambiar estado de la reserva</div>
                <div class="step-desc">Para confirmar una reserva pendiente, abre la reserva y cambia el campo "Status" de "pending" a "confirmed". También puedes cambiar el "Payment Status" si el pago fue confirmado fuera de línea.</div>
              </div>
            </div>
          </div>
        </div>
      </section>

      <div class="divider"></div>

      <!-- ══════════════════════
           PAGOS
      ════════════════════════ -->
      <section class="section" id="pagos">
        <div class="section-header">
          <span class="section-num">09</span>
          <h2 class="section-title">Pagos</h2>
        </div>

        <div class="intro-box" style="margin-bottom: 24px;">
          La sección de <strong>Pagos</strong> muestra el historial de todas las transacciones de pago procesadas a través de OpenPay (la plataforma de pagos). Aquí puedes verificar que los pagos se realizaron correctamente.
        </div>

        <div class="info-box">
          <div class="info-icon">👁️</div>
          <div><strong>Solo lectura:</strong> La sección de pagos es únicamente para consulta. No puedes crear, editar ni eliminar pagos desde aquí. Esto es intencional para mantener la integridad de los registros financieros.</div>
        </div>

        <div class="subsection">
          <h3 class="subsection-title">Campos de un <em>pago</em></h3>

          <table class="field-table">
            <thead>
              <tr>
                <th>Campo</th>
                <th>Descripción</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td><span class="field-name">ID Reserva</span></td>
                <td><span class="field-desc">El identificador único de la reserva asociada a este pago.</span></td>
              </tr>
              <tr>
                <td><span class="field-name">Amount</span></td>
                <td><span class="field-desc">El monto total del pago en pesos mexicanos (MXN).</span></td>
              </tr>
              <tr>
                <td><span class="field-name">Currency</span></td>
                <td><span class="field-desc">La moneda del pago. Generalmente "MXN" (pesos mexicanos).</span></td>
              </tr>
              <tr>
                <td><span class="field-name">Status</span></td>
                <td><span class="field-desc">El estado del pago: <strong>Completado</strong> (el cliente sí pagó), <strong>Pendiente</strong> (esperando confirmación), <strong>Fallido</strong> (el pago fue rechazado), <strong>Reembolsado</strong> (se devolvió el dinero al cliente).</span></td>
              </tr>
              <tr>
                <td><span class="field-name">Payment Method</span></td>
                <td><span class="field-desc">El método utilizado: tarjeta de crédito, débito, etc.</span></td>
              </tr>
              <tr>
                <td><span class="field-name">ID OpenPay</span></td>
                <td><span class="field-desc">El identificador que genera OpenPay para esta transacción. Es útil para investigar problemas o disputas con el banco.</span></td>
              </tr>
              <tr>
                <td><span class="field-name">Error Message</span></td>
                <td><span class="field-desc">Si el pago falló, aquí aparecerá el mensaje de error que dio el banco o OpenPay.</span></td>
              </tr>
            </tbody>
          </table>
        </div>
      </section>

      <div class="divider"></div>

      <!-- ══════════════════════
           PROMOCIONES
      ════════════════════════ -->
      <section class="section" id="promociones">
        <div class="section-header">
          <span class="section-num">10</span>
          <h2 class="section-title">Promociones y <em>Códigos de Descuento</em></h2>
        </div>

        <div class="intro-box" style="margin-bottom: 24px;">
          La sección de <strong>Promociones</strong> te permite crear códigos de descuento que los clientes pueden aplicar al hacer su reserva. Por ejemplo, un código <code>VERANO2026</code> que da 15% de descuento en todos los tours.
        </div>

        <div class="subsection">
          <h3 class="subsection-title">Campos del <em>formulario</em> de promoción</h3>

          <table class="field-table">
            <thead>
              <tr>
                <th>Campo</th>
                <th>Tipo</th>
                <th>Descripción</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td><span class="field-name">Name</span></td>
                <td><span class="field-required">Obligatorio</span></td>
                <td><span class="field-desc">El nombre interno de la promoción (no es el código que ingresa el cliente). Ejemplo: "Descuento Verano 2026".</span></td>
              </tr>
              <tr>
                <td><span class="field-name">Code</span></td>
                <td><span class="field-required">Obligatorio</span></td>
                <td><span class="field-desc">El código que el cliente debe escribir para aplicar el descuento. Ejemplo: "VERANO2026", "DESCUENTO20", "BLACKFRIDAY". Debe ser fácil de escribir y recordar.</span></td>
              </tr>
              <tr>
                <td><span class="field-name">Description</span></td>
                <td><span class="field-optional">Opcional</span></td>
                <td><span class="field-desc">Descripción que aparece al cliente. Ejemplo: "15% de descuento en todos los tours".</span></td>
              </tr>
              <tr>
                <td><span class="field-name">Discount Type</span></td>
                <td><span class="field-required">Obligatorio</span></td>
                <td><span class="field-desc">Cómo se aplica el descuento: <strong>percentage</strong> (porcentaje, ej: 15% de descuento) o <strong>fixed</strong> (cantidad fija, ej: $200 de descuento).</span></td>
              </tr>
              <tr>
                <td><span class="field-name">Discount Value</span></td>
                <td><span class="field-required">Obligatorio</span></td>
                <td><span class="field-desc">El valor del descuento. Si es tipo percentage, escribe solo el número (ej: 15 para 15%). Si es tipo fixed, escribe el monto en pesos (ej: 200 para $200 MXN).</span></td>
              </tr>
              <tr>
                <td><span class="field-name">Start Date</span></td>
                <td><span class="field-required">Obligatorio</span></td>
                <td><span class="field-desc">La fecha desde la cual el código es válido y puede ser usado.</span></td>
              </tr>
              <tr>
                <td><span class="field-name">End Date</span></td>
                <td><span class="field-required">Obligatorio</span></td>
                <td><span class="field-desc">La fecha hasta la cual el código es válido. Después de esta fecha, el código deja de funcionar automáticamente.</span></td>
              </tr>
              <tr>
                <td><span class="field-name">Usage Limit</span></td>
                <td><span class="field-optional">Opcional</span></td>
                <td><span class="field-desc">El número máximo de veces que este código puede ser usado. Ejemplo: si pones "100", el código dejará de funcionar después de que 100 personas lo hayan usado. Déjalo vacío para uso ilimitado.</span></td>
              </tr>
              <tr>
                <td><span class="field-name">Min Purchase</span></td>
                <td><span class="field-optional">Opcional</span></td>
                <td><span class="field-desc">La compra mínima requerida para poder usar el código. Ejemplo: si pones "500", el cliente solo puede usar el código si su reserva es de $500 o más.</span></td>
              </tr>
              <tr>
                <td><span class="field-name">Is Active</span></td>
                <td><span class="field-toggle">Interruptor</span></td>
                <td><span class="field-desc">Si está apagado, el código no puede ser usado aunque esté dentro del período de validez.</span></td>
              </tr>
            </tbody>
          </table>
        </div>
      </section>

      <div class="divider"></div>

      <!-- ══════════════════════
           CONFIGURACIÓN
      ════════════════════════ -->
      <section class="section" id="configuracion">
        <div class="section-header">
          <span class="section-num">11</span>
          <h2 class="section-title">Configuración del <em>Sitio</em></h2>
        </div>

        <div class="intro-box" style="margin-bottom: 24px;">
          La sección de <strong>Configuración del Sitio</strong> te permite cambiar los datos generales de la plataforma: el nombre de tu marca, los colores, la información de contacto, redes sociales y qué servicios están activos. Solo existe una configuración, no puedes crear más.
        </div>

        <div class="info-box">
          <div class="info-icon">ℹ️</div>
          <div><strong>Solo edición:</strong> Esta sección no tiene botón de "Crear" ni de "Eliminar". Solo puedes editar la configuración existente. Si necesitas agregar más configuraciones (por ejemplo, para otro idioma), eso requiere cambios de programación.</div>
        </div>

        <div class="subsection">
          <h3 class="subsection-title">Marca e <em>identidad</em></h3>

          <table class="field-table">
            <thead>
              <tr>
                <th>Campo</th>
                <th>Descripción</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td><span class="field-name">Brand Name</span></td>
                <td><span class="field-desc">El nombre de tu empresa o plataforma. Ejemplo: "Booking Caribe".</span></td>
              </tr>
              <tr>
                <td><span class="field-name">Brand Tagline</span></td>
                <td><span class="field-desc">El slogan o frase de tu marca. Ejemplo: "Tours, hoteles y traslados en el Caribe Mexicano".</span></td>
              </tr>
              <tr>
                <td><span class="field-name">Logo URL</span></td>
                <td><span class="field-desc">La dirección de internet de tu logo. Para cambiarlo, actualmente necesitas ayuda de un programador.</span></td>
              </tr>
              <tr>
                <td><span class="field-name">Favicon URL</span></td>
                <td><span class="field-desc">El ícono pequeño que aparece en la pestaña del navegador. También requiere ayuda de un programador para cambiarlo.</span></td>
              </tr>
              <tr>
                <td><span class="field-name">Site URL</span></td>
                <td><span class="field-desc">La dirección principal de tu sitio web. Ejemplo: "https://idayvueltamx.com".</span></td>
              </tr>
            </tbody>
          </table>
        </div>

        <div class="subsection">
          <h3 class="subsection-title"><em>Colores</em> del sitio</h3>

          <table class="field-table">
            <thead>
              <tr>
                <th>Campo</th>
                <th>Descripción</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td><span class="field-name">Color Primary</span></td>
                <td><span class="field-desc">El color principal de la página web (en código hexadecimal). Ejemplo: "#0891b2" es un tono cyan. Este color se usa en botones principales, enlaces y elementos destacados.</span></td>
              </tr>
              <tr>
                <td><span class="field-name">Color Secondary</span></td>
                <td><span class="field-desc">El color secundario de la página web. Ejemplo: "#f97316" es un tono naranja/coral. Se usa para acentos y elementos secundarios.</span></td>
              </tr>
              <tr>
                <td><span class="field-name">Color Accent</span></td>
                <td><span class="field-desc">El color de acento. Ejemplo: "#f59e0b" es un tono dorado. Se usa para detalles como badges, íconos destacados y elementos decorativos.</span></td>
              </tr>
            </tbody>
          </table>

          <div class="info-box">
            <div class="info-icon">🎨</div>
            <div>Para cambiar un color, haz clic en el campo del color, se abrirá un selector. Los colores están en formato hexadecimal (como #0891b2). Si no estás familiarizado con esto, puedes buscar "colores hex" en internet para encontrar el código del color que quieres.</div>
          </div>
        </div>

        <div class="subsection">
          <h3 class="subsection-title">Servicios <em>habilitados</em></h3>

          <table class="field-table">
            <thead>
              <tr>
                <th>Campo</th>
                <th>Descripción</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td><span class="field-name">Service Hotels</span></td>
                <td><span class="field-desc">Si está encendido, la sección de hoteles aparece en la página web. Si está apagado, la sección de hoteles desaparece por completo.</span></td>
              </tr>
              <tr>
                <td><span class="field-name">Service Tours</span></td>
                <td><span class="field-desc">Si está encendido, la sección de tours aparece en la página web.</span></td>
              </tr>
              <tr>
                <td><span class="field-name">Service Transfers</span></td>
                <td><span class="field-desc">Si está encendido, la sección de traslados aparece en la página web.</span></td>
              </tr>
            </tbody>
          </table>
        </div>

        <div class="subsection">
          <h3 class="subsection-title">Ubicación y <em>SEO</em></h3>

          <table class="field-table">
            <thead>
              <tr>
                <th>Campo</th>
                <th>Descripción</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td><span class="field-name">Location Name</span></td>
                <td><span class="field-desc">El nombre de la ubicación principal. Ejemplo: "Riviera Maya & Cancún".</span></td>
              </tr>
              <tr>
                <td><span class="field-name">Location Region</span></td>
                <td><span class="field-desc">La región o estado. Ejemplo: "Quintana Roo".</span></td>
              </tr>
              <tr>
                <td><span class="field-name">Location Country</span></td>
                <td><span class="field-desc">El país. Ejemplo: "México".</span></td>
              </tr>
              <tr>
                <td><span class="field-name">Location Description</span></td>
                <td><span class="field-desc">Una descripción de la ubicación que puede aparecer en meta tags para SEO (búsquedas de Google).</span></td>
              </tr>
              <tr>
                <td><span class="field-name">SEO Keywords</span></td>
                <td><span class="field-desc">Palabras clave separadas por comas que ayudan a que tu sitio aparezca en Google. Ejemplo: "tours cancun,hoteles riviera maya,traslado aeropuerto cancun".</span></td>
              </tr>
            </tbody>
          </table>
        </div>

        <div class="subsection">
          <h3 class="subsection-title"><em>Contacto</em></h3>

          <table class="field-table">
            <thead>
              <tr>
                <th>Campo</th>
                <th>Descripción</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td><span class="field-name">WhatsApp</span></td>
                <td><span class="field-desc">El número de WhatsApp para contacto. Ejemplo: "+52 998 123 4567". Este número puede aparecer en el botón flotante de WhatsApp en la página web.</span></td>
              </tr>
              <tr>
                <td><span class="field-name">Phone</span></td>
                <td><span class="field-desc">El número de teléfono principal de contacto.</span></td>
              </tr>
              <tr>
                <td><span class="field-name">Email</span></td>
                <td><span class="field-desc">El correo electrónico de contacto. Ejemplo: "reservas@idayvueltamx.com".</span></td>
              </tr>
              <tr>
                <td><span class="field-name">Address</span></td>
                <td><span class="field-desc">La dirección física de tu negocio u oficina.</span></td>
              </tr>
            </tbody>
          </table>
        </div>

        <div class="subsection">
          <h3 class="subsection-title">Redes <em>Sociales</em></h3>

          <table class="field-table">
            <thead>
              <tr>
                <th>Campo</th>
                <th>Descripción</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td><span class="field-name">Facebook</span></td>
                <td><span class="field-desc">La URL de tu página de Facebook. Ejemplo: "https://facebook.com/bookingcaribe".</span></td>
              </tr>
              <tr>
                <td><span class="field-name">Instagram</span></td>
                <td><span class="field-desc">La URL de tu perfil de Instagram.</span></td>
              </tr>
              <tr>
                <td><span class="field-name">Twitter / X</span></td>
                <td><span class="field-desc">La URL de tu perfil de Twitter o X.</span></td>
              </tr>
            </tbody>
          </table>
        </div>

        <div class="subsection">
          <h3 class="subsection-title">Funcionalidades y <em>Analytics</em></h3>

          <table class="field-table">
            <thead>
              <tr>
                <th>Campo</th>
                <th>Descripción</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td><span class="field-name">Enable Promo Codes</span></td>
                <td><span class="field-desc">Si está encendido, los clientes pueden ingresar códigos de descuento al hacer una reserva. Si está apagado, no se pueden usar códigos.</span></td>
              </tr>
              <tr>
                <td><span class="field-name">GA ID</span></td>
                <td><span class="field-desc">El identificador de Google Analytics para rastrear visitantes del sitio. Ejemplo: "G-XXXXXXXXXX". Este campo generalmente lo proporciona Google Analytics.</span></td>
              </tr>
              <tr>
                <td><span class="field-name">FB Pixel</span></td>
                <td><span class="field-desc">El código del píxel de Facebook para rastrear conversiones y hacer publicidad en Facebook. Ejemplo: "XXXXXXXXXXXXXXXX".</span></td>
              </tr>
            </tbody>
          </table>
        </div>
      </section>

      <div class="divider"></div>

      <!-- ══════════════════════
           LO QUE NO SE PUEDE HACER
      ════════════════════════ -->
      <section class="section" id="no-se-puede">
        <div class="section-header">
          <span class="section-num">12</span>
          <h2 class="section-title">Lo que <em>NO</em> se puede hacer</h2>
        </div>

        <div class="warning-box" style="margin-bottom: 28px;">
          <div class="warning-icon">⚠️</div>
          <div class="warning-title">No se pueden agregar campos nuevos</div>
          <div class="warning-text">
            <strong>El sistema solo permite capturar la información que los desarrolladores definieron de antemano.</strong> Si necesitas agregar un campo nuevo que no existe (por ejemplo: "color de habitación", "idioma del guía", "equipaje permitido para tours", "número de vuelo", "nombre de la aseguradora", etc.), <strong>actualmente no hay forma de hacerlo desde el panel</strong>. Eso requiere que un programador modifique el código del sistema, agregue el campo en la base de datos, lo añada al formulario en el panel de administración y lo muestre también en la página web pública.<br><br>
            Esta es la limitación más importante del sistema actualmente. Si necesitas capturar información que no está en los formularios, tienes que solicitar al equipo técnico que lo agregue.
          </div>
        </div>

        <div class="subsection">
          <h3 class="subsection-title">Otras <em>limitaciones</em> del sistema</h3>

          <div class="limit-list">
            <div class="limit-item">
              <div class="limit-icon">❌</div>
              <div class="limit-text"><strong>No se pueden crear más usuarios administradores</strong> — No hay forma de crear nuevas cuentas de administrador desde el panel. Actualmente solo existe una cuenta (<code>admin@booking.com</code>). Para agregar más usuarios, hay que hacerlo directamente en la base de datos.</div>
            </div>
            <div class="limit-item">
              <div class="limit-icon">❌</div>
              <div class="limit-text"><strong>No se reciben correos de confirmación automáticos</strong> — Cuando un cliente hace una reserva desde la página web, no recibe correo electrónico de confirmación. El administrador tiene que contactar al cliente manualmente.</div>
            </div>
            <div class="limit-item">
              <div class="limit-icon">❌</div>
              <div class="limit-text"><strong>No hay forma de exportar o imprimir reservas</strong> — No existe botón para generar un PDF, ticket, comprobante o invoice de la reserva. Todo es solo digital dentro del panel.</div>
            </div>
            <div class="limit-item">
              <div class="limit-icon">❌</div>
              <div class="limit-text"><strong>El dashboard no muestra estadísticas</strong> — La página principal del panel (dashboard) solo muestra widgets básicos. No hay gráficos de ventas, número de reservas del mes, ingresos, hoteles más reservados, etc.</div>
            </div>
            <div class="limit-item">
              <div class="limit-icon">❌</div>
              <div class="limit-text"><strong>No se envían notificaciones al cambiar estado de reserva</strong> — Cuando cambias el estado de una reserva de "pendiente" a "confirmada", el cliente no recibe ninguna notificación por email.</div>
            </div>
            <div class="limit-item">
              <div class="limit-icon">❌</div>
              <div class="limit-text"><strong>No hay flujo de reembolsos</strong> — No hay un proceso definido en el panel para reembolsar el dinero a un cliente. Solo se puede marcar manualmente en la base de datos.</div>
            </div>
            <div class="limit-item">
              <div class="limit-icon">❌</div>
              <div class="limit-text"><strong>No hay filtros avanzados en reservas</strong> — No puedes filtrar reservas por rango de fechas, estado o cliente. Tienes que buscar manualmente en la lista.</div>
            </div>
            <div class="limit-item">
              <div class="limit-icon">❌</div>
              <div class="limit-text"><strong>El sitio solo está en español</strong> — No hay forma de agregar traducciones a otros idiomas (inglés, francés, etc.) desde el panel.</div>
            </div>
            <div class="limit-item">
              <div class="limit-icon">❌</div>
              <div class="limit-text"><strong>No se pueden programar reservas automáticas</strong> — No hay forma de crear reservas que se generen automáticamente en fechas futuras.</div>
            </div>
            <div class="limit-item">
              <div class="limit-icon">❌</div>
              <div class="limit-text"><strong>No hay gestión de disponibilidad por fechas</strong> — El sistema no tiene un calendario de disponibilidad. No puedes bloquear fechas específicas para un hotel o tour.</div>
            </div>
            <div class="limit-item">
              <div class="limit-icon">❌</div>
              <div class="limit-text"><strong>No hay forma de ver qué imágenes están asociadas a cada servicio</strong> — Si subiste imágenes y no recuerdas cuáles le pusiste a cada hotel, no hay manera de verlo fácilmente desde el panel.</div>
            </div>
          </div>
        </div>
      </section>

      <div class="divider"></div>

      <!-- ══════════════════════
           CERRAR SESIÓN
      ════════════════════════ -->
      <section class="section" id="cerrar-sesion">
        <div class="section-header">
          <span class="section-num">13</span>
          <h2 class="section-title">Cómo <em>cerrar sesión</em></h2>
        </div>

        <div class="steps">
          <div class="step">
            <div class="step-num">1</div>
            <div class="step-content">
              <div class="step-title">Busca tu nombre o icono de usuario arriba</div>
              <div class="step-desc">Generalmente, en la parte superior derecha del panel hay un espacio que muestra tu nombre o un círculo con la inicial de tu nombre.</div>
            </div>
          </div>
          <div class="step">
            <div class="step-num">2</div>
            <div class="step-content">
              <div class="step-title">Haz clic en él</div>
              <div class="step-desc">Se desplegará un menú con opciones.</div>
            </div>
          </div>
          <div class="step">
            <div class="step-num">3</div>
            <div class="step-content">
              <div class="step-title">Busca la opción "Logout", "Cerrar sesión" o "Salir"</div>
              <div class="step-desc">Generalmente está al final del menú desplegable.</div>
            </div>
          </div>
          <div class="step">
            <div class="step-num">4</div>
            <div class="step-content">
              <div class="step-title">Haz clic en ella</div>
              <div class="step-desc">Se cerrará tu sesión y serás redirigido a la página de login.</div>
            </div>
          </div>
        </div>

        <div class="info-box">
          <div class="info-icon">🔒</div>
          <div><strong>¿Por qué es importante cerrar sesión?</strong><br>
          Si estás en una computadora compartida y no cierras sesión, cualquier persona que use esa computadora después de ti podría entrar al panel de administración y hacer cambios en tu plataforma. Siempre cierra sesión cuando termines de trabajar.</div>
        </div>
      </section>

    </div><!-- /content -->
  </main>

</div><!-- /shell -->

</body>
</html>