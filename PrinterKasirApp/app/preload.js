const { contextBridge, ipcRenderer } = require('electron')

console.log('🟢 PRELOAD LOADED')  

contextBridge.exposeInMainWorld('electronAPI', {
  startSystem: () => ipcRenderer.invoke('start-system'),
  getPublicUrlNgrok: () => ipcRenderer.invoke('get-public-url')
})
