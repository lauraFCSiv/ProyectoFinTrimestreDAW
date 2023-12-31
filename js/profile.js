// Función para cambiar el tema
function changeTheme(themeName) {
  // Para deshabilitar todos los estilos
  let styleSheet = document.getElementById("claro");
  let styleSheetOscuro = document.getElementById("oscuro");
  let styleSheetCalido = document.getElementById("calido");

  if (styleSheet && styleSheetOscuro && styleSheetCalido) {
    styleSheet.disabled = true;
    styleSheetOscuro.disabled = true;
    styleSheetCalido.disabled = true;

    // Habilita el estilo seleccionado
    let selectedStyleSheet = document.getElementById(themeName);
    if (selectedStyleSheet) {
      selectedStyleSheet.disabled = false;

      // Guarda el tema seleccionado en el localStorage
      localStorage.setItem("theme", themeName);
    } else {
      console.log("No se encontró el estilo especificado");
    }
  } else {
    console.log("No se encontraron elementos con los IDs especificados");
  }
}

// Verifica si hay un tema almacenado en el localStorage y aplícalo al cargar la página
document.addEventListener("DOMContentLoaded", function () {
  let storedTheme = localStorage.getItem("theme");
  if (storedTheme) {
    changeTheme(storedTheme);
  }
});
