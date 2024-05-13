

const { app, BrowserWindow } = require("electron");
const url = require("url");

let mainWindow;


function createWindow() {
  // Crie a janela principal
  mainWindow = new BrowserWindow({
    width: 800,
    height: 600,
    frame: false, // Remova a barra de ferramentas padrão
  });


  mainWindow.loadURL(
    url.format({
      pathname: "recorver.html",
      slashes: true,
    })
  );

  // Evento para fechar a janela principal
  mainWindow.on("closed", () => {
    mainWindow = null;
  });
  mainWindow.setFullScreen(true);
}


app.on("ready", createWindow);

