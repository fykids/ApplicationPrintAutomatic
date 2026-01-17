console.log('🟡 RENDERER LOADED')

let currentUrl = null
let qrInstance = null

async function updateQrIfNeeded() {
  try {
    const url = await window.electronAPI.getPublicUrlNgrok()
    if (!url) return

    // jika URL sama, tidak perlu update
    if (url === currentUrl) return

    currentUrl = url

    // tampilkan URL
    document.getElementById('url').innerText = url

    // reset QR
    const qrEl = document.getElementById('qrcode')
    qrEl.innerHTML = ''

    qrInstance = new QRCode(qrEl, {
      text: url,
      width: 200,
      height: 200
    })

    console.log('QR updated:', url)

  } catch (err) {
    console.error('Failed update QR', err)
  }
}

// pertama kali load
window.onload = () => {
  updateQrIfNeeded()

  // auto refresh tiap 5 detik
  setInterval(updateQrIfNeeded, 5000)
}
