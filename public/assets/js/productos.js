const STORAGE_KEY = "inventario_productos";

const form = document.querySelector("#producto-form");
const idInput = document.querySelector("#producto-id");
const nameInput = document.querySelector("#nombre");
const stockInput = document.querySelector("#stock");
const priceInput = document.querySelector("#precio");
const messageBox = document.querySelector("#producto-mensaje");
const cancelButton = document.querySelector("#cancelar-edicion");
const tableBody = document.querySelector("#tabla-productos");
const emptyState = document.querySelector("#estado-vacio");
const counter = document.querySelector("#contador-productos");
const modeLabel = document.querySelector("#modo-formulario");
const totalStock = document.querySelector("#stat-stock");
const totalValue = document.querySelector("#stat-value");
const lowStock = document.querySelector("#stat-low-stock");

function readProducts() {
  const stored = localStorage.getItem(STORAGE_KEY);

  if (!stored) {
    return [];
  }

  try {
    const parsed = JSON.parse(stored);
    return Array.isArray(parsed) ? parsed : [];
  } catch {
    return [];
  }
}

function saveProducts(products) {
  localStorage.setItem(STORAGE_KEY, JSON.stringify(products));
}

function showMessage(text, type) {
  messageBox.hidden = false;
  messageBox.textContent = text;
  messageBox.className = `notice ${type}`;
}

function hideMessage() {
  messageBox.hidden = true;
  messageBox.textContent = "";
  messageBox.className = "notice";
}

function resetForm() {
  form.reset();
  idInput.value = "";
  modeLabel.textContent = "Modo actual: creación de producto";
  hideMessage();
}

function validateProduct(product) {
  const errors = [];

  if (!product.nombre.trim()) {
    errors.push("El nombre no puede estar vacío.");
  }

  if (!Number.isInteger(product.stock) || product.stock < 0) {
    errors.push("El stock debe ser un entero mayor o igual a 0.");
  }

  if (!Number.isFinite(product.precio) || product.precio <= 0) {
    errors.push("El precio debe ser mayor a 0.");
  }

  return errors;
}

function formatMoney(amount) {
  return `$${amount.toFixed(2)}`;
}

function escapeHtml(value) {
  return value
    .replaceAll("&", "&amp;")
    .replaceAll("<", "&lt;")
    .replaceAll(">", "&gt;")
    .replaceAll('"', "&quot;")
    .replaceAll("'", "&#039;");
}

function renderProducts() {
  const products = readProducts();
  tableBody.innerHTML = "";

  emptyState.hidden = products.length > 0;
  counter.textContent = `${products.length} producto${products.length === 1 ? "" : "s"}`;
  totalStock.textContent = `${products.reduce((sum, product) => sum + product.stock, 0)} unidades`;
  totalValue.textContent = formatMoney(
    products.reduce((sum, product) => sum + product.stock * product.precio, 0),
  );
  lowStock.textContent = `${products.filter((product) => product.stock > 0 && product.stock <= 5).length} productos`;

  products.forEach((product) => {
    const row = document.createElement("tr");
    const stockClass =
      product.stock === 0 ? "empty" : product.stock <= 5 ? "low" : "normal";
    const stockLabel =
      product.stock === 0
        ? "Sin stock"
        : product.stock <= 5
          ? "Stock bajo"
          : "Disponible";

    row.innerHTML = `
      <td>${escapeHtml(product.nombre)}</td>
      <td>
        <div>${product.stock} unidades</div>
        <span class="stock-badge ${stockClass}">${stockLabel}</span>
      </td>
      <td>${formatMoney(product.precio)}</td>
      <td>
        <div class="action-buttons">
          <button class="button ghost" type="button" data-action="editar" data-id="${product.id}">Editar</button>
          <button class="button danger" type="button" data-action="eliminar" data-id="${product.id}">Eliminar</button>
        </div>
      </td>
    `;

    tableBody.appendChild(row);
  });
}

function fillForm(product) {
  idInput.value = product.id;
  nameInput.value = product.nombre;
  stockInput.value = String(product.stock);
  priceInput.value = String(product.precio);
  modeLabel.textContent = `Modo actual: edición de ${product.nombre}`;
  hideMessage();
  nameInput.focus();
}

function handleSubmit(event) {
  event.preventDefault();

  const product = {
    id: idInput.value || String(Date.now()),
    nombre: nameInput.value.trim(),
    stock: Number.parseInt(stockInput.value, 10),
    precio: Number.parseFloat(priceInput.value),
  };

  const errors = validateProduct(product);

  if (errors.length > 0) {
    showMessage(errors.join(" "), "error");
    return;
  }

  const products = readProducts();
  const index = products.findIndex((item) => item.id === product.id);

  if (index >= 0) {
    products[index] = product;
    showMessage("Producto actualizado correctamente.", "success");
  } else {
    products.push(product);
    showMessage("Producto creado correctamente.", "success");
  }

  saveProducts(products);
  renderProducts();
  window.setTimeout(resetForm, 700);
}

function handleTableClick(event) {
  const button = event.target.closest("button[data-action]");

  if (!button) {
    return;
  }

  const products = readProducts();
  const product = products.find((item) => item.id === button.dataset.id);

  if (!product) {
    showMessage("No se encontró el producto seleccionado.", "error");
    return;
  }

  if (button.dataset.action === "editar") {
    fillForm(product);
    return;
  }

  if (
    !window.confirm(
      `Se eliminará el producto "${product.nombre}". ¿Deseas continuar?`,
    )
  ) {
    return;
  }

  const filtered = products.filter((item) => item.id !== product.id);
  saveProducts(filtered);
  renderProducts();
  resetForm();
  showMessage("Producto eliminado correctamente.", "success");
}

form.addEventListener("submit", handleSubmit);
tableBody.addEventListener("click", handleTableClick);
cancelButton.addEventListener("click", resetForm);

renderProducts();
resetForm();
