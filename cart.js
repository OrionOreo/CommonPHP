document.addEventListener("DOMContentLoaded", () => {
  const container = document.querySelector(".product_row_wrapper");
  if (!container) return;

  // --- Quantity buttons ---
  container.addEventListener("click", (e) => {
    const addBtn = e.target.closest(".quantity_add");
    const minusBtn = e.target.closest(".quantity_minus");

    if (!addBtn && !minusBtn) return;

    e.preventDefault();
    e.stopPropagation(); // important for Swiper

    const card = e.target.closest(".product_card");
    if (!card) return;

    const input = card.querySelector(".add_to_cart_quantity");
    if (!input) return;

    const min = parseInt(input.min) || 1;
    const max = parseInt(input.max) || 100;
    let val = parseInt(input.value) || min;

    if (addBtn && val < max) input.value = val + 1;
    if (minusBtn && val > min) input.value = val - 1;
  });

  // --- Input sanitisation ---
  container.addEventListener("input", (e) => {
    const input = e.target.closest(".add_to_cart_quantity");
    if (!input) return;

    let val = input.value.replace(/\D/g, "");
    const min = parseInt(input.min) || 1;
    const max = parseInt(input.max) || 100;

    if (val === "") {
      input.value = "";
      return;
    }

    val = parseInt(val);
    if (val < min) val = min;
    if (val > max) val = max;

    input.value = val;
  });

  // --- Paste handling ---
  container.addEventListener("paste", (e) => {
    const input = e.target.closest(".add_to_cart_quantity");
    if (!input) return;

    e.preventDefault();

    const paste = (e.clipboardData || window.clipboardData).getData(
      "text",
    );
    if (!/^\d+$/.test(paste)) return;

    const min = parseInt(input.min) || 1;
    const max = parseInt(input.max) || 100;

    let val = parseInt(paste);
    if (val < min) val = min;
    if (val > max) val = max;

    input.value = val;
  });

  // --- Read more button ---
  container.addEventListener("click", (e) => {
    const btn = e.target.closest(".product_read_more");
    if (!btn) return;

    e.preventDefault();
    e.stopPropagation();

    const card = btn.closest(".product_card");
    const link = card?.querySelector("a[href]");
    if (link) location.href = link.href;
  });
});
