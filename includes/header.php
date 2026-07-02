<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PocketLedger Retro</title>
    <!-- Tailwind CSS v3 Play CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Chart.js & html2pdf.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Share+Tech+Mono&family=VT323&display=swap" rel="stylesheet">
    
    <script>
        tailwind.config = {
          darkMode: 'class',
        }
    </script>
    <style>
        :root, .theme-light {
          --bg-app: #FDFDFD; --bg-card: #FFFFFF; --bg-input: #FFFFFF;
          --text-main: #000000; --text-sub: #737373; --border-main: #000000;
        }
        .dark, .theme-dark {
          --bg-app: #121214; --bg-card: #1E1E22; --bg-input: #121214;
          --text-main: #FFFFFF; --text-sub: #A3A3A3; --border-main: #FFFFFF;
        }
        html, body { 
          background-color: var(--bg-app) !important; 
          color: var(--text-main) !important; 
          font-family: 'Share Tech Mono', monospace;
        }
        input:not([type="range"]), select, textarea, option { 
          background-color: var(--bg-input) !important; 
          color: var(--text-main) !important; 
          border: 2px solid var(--border-main) !important; 
        }
        .pixel-text { font-family: 'VT323', monospace; }
        .retro-shadow { box-shadow: 4px 4px 0px 0px var(--border-main); }
        .retro-shadow-sm { box-shadow: 2px 2px 0px 0px var(--border-main); }
        .retro-shadow-active:active { transform: translate(1px, 1px); box-shadow: 1px 1px 0px 0px var(--border-main); }

        /* Custom Retro Scrollbar */
        .custom-scrollbar::-webkit-scrollbar { width: 10px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: var(--bg-card); border-left: 2px solid var(--border-main); }
        .custom-scrollbar::-webkit-scrollbar-thumb { background-color: var(--border-main); }
    </style>
</head>
<body class="min-h-screen flex flex-col justify-between select-none transition-colors duration-200">
