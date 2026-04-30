const PRODUCT_STORAGE_KEY = "inventario_productos";

const productSelector = document.querySelector("#product-selector");
const productIdField = document.querySelector("#product_id");
const productNameField = document.querySelector("#product_name");
const unitPriceField = document.querySelector("#unit_price");
const availableStockField = document.querySelector("#available_stock");
const quantityField = document.querySelector("#quantity");
const summaryBox = document.querySelector("#venta-resumen");
const saleMessage = document.querySelector("#venta-mensaje");
const saleForm = document.querySelector("#venta-form");

function readProducts() {
  const stored = localStorage.getItem(PRODUCT_STORAGE_KEY);

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
  localStorage.setItem(PRODUCT_STORAGE_KEY, JSON.stringify(products));
}

function formatMoney(amount) {
  return `$${Number(amount).toFixed(2)}`;
}

function setSaleMessage(text, type) {
  saleMessage.hidden = false;
  saleMessage.textContent = text;
  saleMessage.className = `notice ${type}`;
}

function clearSaleMessage() {
  saleMessage.hidden = true;
  saleMessage.textContent = "";
  saleMessage.className = "notice";
}

function populateProducts() {
  const products = readProducts();
  productSelector.innerHTML =
    '<option value="">Selecciona un producto</option>';

  products.forEach((product) => {
    const option = document.createElement("option");
    option.value = product.id;
    option.textContent = `${product.nombre} | Stock: ${product.stock} | ${formatMoney(product.precio)}`;
    productSelector.appendChild(option);
  });

  if (products.length === 0) {
    setSaleMessage(
      "Primero debes registrar productos en el módulo de inventario.",
      "error",
    );
  }
}

function updateSelectedProduct() {
  clearSaleMessage();

  const selectedId = productSelector.value;
  const product = readProducts().find((item) => item.id === selectedId);

  if (!product) {
    productIdField.value = "";
    productNameField.value = "";
    unitPriceField.value = "";
    availableStockField.value = "";
    quantityField.max = "";
    summaryBox.textContent =
      "Selecciona un producto para ver stock y precio disponible.";
    return;
  }

  productIdField.value = product.id;
  productNameField.value = product.nombre;
  unitPriceField.value = String(product.precio);
  availableStockField.value = String(product.stock);
  quantityField.max = String(product.stock);
  summaryBox.textContent = `Producto: ${product.nombre} | Precio unitario: ${formatMoney(product.precio)} | Stock disponible: ${product.stock}`;

  if (product.stock === 0) {
    setSaleMessage(
      "El producto seleccionado no tiene stock disponible.",
      "error",
    );
  }
}

function syncSoldStock() {
  if (!window.saleSyncPayload || !window.saleSyncPayload.product_id) {
    return;
  }

  const updatedProducts = readProducts().map((product) => {
    if (product.id !== window.saleSyncPayload.product_id) {
      return product;
    }

    return {
      ...product,
      stock: Math.max(
        0,
        Number(product.stock) - Number(window.saleSyncPayload.quantity),
      ),
    };
  });

  saveProducts(updatedProducts);
  window.saleSyncPayload = null;
}

function validateSaleBeforeSubmit(event) {
  const product = readProducts().find(
    (item) => item.id === productSelector.value,
  );
  const quantity = Number.parseInt(quantityField.value, 10);

  if (!product) {
    event.preventDefault();
    setSaleMessage("Debes seleccionar un producto válido.", "error");
    return;
  }

  if (!Number.isInteger(quantity) || quantity < 1) {
    event.preventDefault();
    setSaleMessage("La cantidad debe ser mayor o igual a 1.", "error");
    return;
  }

  if (quantity > Number(product.stock)) {
    event.preventDefault();
    setSaleMessage(
      "La cantidad no puede superar el stock disponible.",
      "error",
    );
  }
}

syncSoldStock();
populateProducts();
updateSelectedProduct();

productSelector.addEventListener("change", updateSelectedProduct);
saleForm.addEventListener("submit", validateSaleBeforeSubmit);
