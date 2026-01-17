console.log('🔥 MAIN PROCESS STARTED')

const { app, BrowserWindow, ipcMain } = require('electron')
const { spawn } = require('child_process')
const path = require('path')

const axios = require('axios')

ipcMain.handle('get-public-url', async () => {
    try {
        const res = await axios.get('http://127.0.0.1:4040/api/tunnels')
        return res.data.tunnels[0].public_url
    } catch (e) {
        console.error('Failed get ngrok url')
        return null
    }
})

function getNgrokPath() {
    if (app.isPackaged) {
        // MODE EXE
        return path.join(process.resourcesPath, 'ngrok', 'ngrok.exe')
    } else {
        // MODE DEV
        return path.join(__dirname, '../ngrok/ngrok.exe')
    }
}

/* =========================
   GLOBAL STATE
========================= */
let systemStarted = false

/* =========================
   HELPER RUN
========================= */
function run(command, args = [], cwd = null, label = 'PROC') {
    console.log(`Running: ${command} ${args.join(' ')}`)

    const p = spawn(command, args, {
        cwd,
        shell: false,
        windowsHide: true
    })

    p.stdout.on('data', d => console.log(`[${label}] ${d}`))
    p.stderr.on('data', d => console.error(`[${label} ERROR] ${d}`))
    p.on('error', err => console.error(`[${label} SPAWN ERROR]`, err))
}

/* =========================
   START SERVICES
========================= */

// 1️⃣ LARAGON (MYSQL + APACHE)
function startLaragon() {
    run('C:\\laragon\\laragon.exe', [], null, 'LARAGON')
}

// 2️⃣ LARAVEL
function startLaravel() {
    run(
        'C:\\laragon\\bin\\php\\php-8.3.28-Win32-vs16-x64\\php.exe',
        ['artisan', 'serve', '--host=0.0.0.0', '--port=8000'],
        'C:\\Users\\Public\\Documents\\Project_Yosua\\app-barcode-qr',
        'LARAVEL'
    )
}

// 3️⃣ PYTHON PRINT SERVICE
function startPython() {
    run(
        'C:\\Users\\DELL\\AppData\\Local\\Programs\\Python\\Python312\\python.exe',
        ['main.py'],
        'C:\\Users\\Public\\Documents\\Project_Yosua\\config',
        'PYTHON'
    )
}

function startNgrok() {
    const ngrokPath = getNgrokPath()

    run(
        ngrokPath,
        ['http', '8000', '--log=stdout'],
        path.dirname(ngrokPath),
        'NGROK'
    )
}

/* =========================
   IPC
========================= */
ipcMain.handle('start-system', async () => {
    if (systemStarted) {
        console.log('⚠️ System already running')
        return { status: 'already-running' }
    }

    systemStarted = true
    console.log('Starting full system...')

    startLaragon()
    startLaravel()
    startPython()
    startNgrok()

    return { status: 'ok' }
})

/* =========================
   WINDOW
========================= */
function createWindow() {
    const win = new BrowserWindow({
        width: 1100,
        height: 700,
        webPreferences: {
            preload: path.join(__dirname, 'preload.js')
        }
    })

    win.loadFile(path.join(__dirname, 'index.html'))
}

app.whenReady().then(createWindow)

process.on('uncaughtException', err => {
    console.error('UNCAUGHT:', err)
})
