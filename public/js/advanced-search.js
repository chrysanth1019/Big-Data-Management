/**
 * Advanced Search Functionality
 * Adds support for multi-select dropdowns, AND/OR operators, and multiple date ranges
 */
document.addEventListener("DOMContentLoaded", function () {
    // Initialize multi-select dropdowns
    initMultiSelectDropdowns();

    // Initialize search operators
    initSearchOperators();

    // Initialize multiple date ranges
    initMultipleDateRanges();

    // Set up form submission
    setupAdvancedSearchForm();
});

/**
 * Initializes all multi-select dropdown elements
 */
function initMultiSelectDropdowns() {
    const selects = document.querySelectorAll(".jp-multiselect-select");

    selects.forEach((select) => {
        // Create wrapper
        const wrapper = document.createElement("div");
        wrapper.className = "jp-multiselect-wrapper";
        select.parentNode.insertBefore(wrapper, select);
        wrapper.appendChild(select);

        // Hide original select
        select.style.display = "none";

        // Create custom multi-select
        const multiSelect = document.createElement("div");
        multiSelect.className = "jp-multiselect";
        multiSelect.innerHTML =
            '<span class="jp-multiselect-placeholder">選択してください</span>';
        wrapper.appendChild(multiSelect);

        // Create dropdown
        const dropdown = document.createElement("div");
        dropdown.className = "jp-multiselect-dropdown";
        wrapper.appendChild(dropdown);

        // Populate dropdown with options
        Array.from(select.options).forEach((option) => {
            const optionElement = document.createElement("div");
            optionElement.className = "jp-multiselect-option";

            const checkbox = document.createElement("input");
            checkbox.type = "checkbox";
            checkbox.value = option.value;
            checkbox.id = `opt-${select.name}-${option.value}`;

            const label = document.createElement("label");
            label.textContent = option.textContent;
            label.htmlFor = checkbox.id;

            optionElement.appendChild(checkbox);
            optionElement.appendChild(label);
            dropdown.appendChild(optionElement);

            // Handle option clicks
            optionElement.addEventListener("click", function (e) {
                if (e.target !== checkbox) {
                    checkbox.checked = !checkbox.checked;
                }

                // Update original select
                option.selected = checkbox.checked;

                // Update display
                updateMultiSelectDisplay(wrapper);

                // Prevent dropdown from closing
                e.stopPropagation();
            });
        });

        // Toggle dropdown on click
        multiSelect.addEventListener("click", function () {
            wrapper.classList.toggle("open");

            // Close other dropdowns
            document
                .querySelectorAll(".jp-multiselect-wrapper.open")
                .forEach((openWrapper) => {
                    if (openWrapper !== wrapper) {
                        openWrapper.classList.remove("open");
                    }
                });
        });

        // Close dropdown when clicking outside
        document.addEventListener("click", function (e) {
            if (!wrapper.contains(e.target)) {
                wrapper.classList.remove("open");
            }
        });

        // Initialize display
        updateMultiSelectDisplay(wrapper);
    });
}

/**
 * Updates the original select element based on checkbox selections
 */
function updateOriginalSelect(selectElement, wrapper) {
    const checkboxes = wrapper.querySelectorAll(
        '.jp-multiselect-option input[type="checkbox"]'
    );
    const options = selectElement.options;

    for (let i = 0; i < options.length; i++) {
        options[i].selected = checkboxes[i].checked;
    }
}

/**
 * Updates the display of a multi-select dropdown
 */
function updateMultiSelectDisplay(wrapper) {
    const select = wrapper.querySelector("select");
    const multiSelect = wrapper.querySelector(".jp-multiselect");
    const options = select.selectedOptions;

    // Clear current display
    multiSelect.innerHTML = "";

    if (options.length === 0) {
        multiSelect.innerHTML =
            '<span class="jp-multiselect-placeholder">選択してください</span>';
        return;
    }

    // Add tags for selected options
    Array.from(options).forEach((option) => {
        const tag = document.createElement("span");
        tag.className = "jp-multiselect-tag";
        tag.dataset.value = option.value;
        tag.innerHTML = `${option.textContent} <span class="jp-multiselect-tag-remove">×</span>`;
        multiSelect.appendChild(tag);

        // Handle tag removal
        tag.querySelector(".jp-multiselect-tag-remove").addEventListener(
            "click",
            function (e) {
                option.selected = false;

                // Update checkbox
                const checkbox = wrapper.querySelector(
                    `.jp-multiselect-option input[value="${option.value}"]`
                );
                if (checkbox) checkbox.checked = false;

                // Update display
                updateMultiSelectDisplay(wrapper);

                e.stopPropagation();
            }
        );
    });
}

/**
 * Initializes search operator toggles (AND/OR)
 */
function initSearchOperators() {
    const operators = document.querySelectorAll(".jp-search-operator");

    operators.forEach((operator) => {
        const options = operator.querySelectorAll(".jp-search-operator-option");
        const input = operator.querySelector('input[type="hidden"]');

        options.forEach((option) => {
            option.addEventListener("click", function () {
                // Remove active class from all options
                options.forEach((opt) => opt.classList.remove("active"));

                // Add active class to clicked option
                this.classList.add("active");

                // Update hidden input
                input.value = this.dataset.value;
            });
        });
    });
}

/**
 * Initializes functionality for multiple date ranges
 */
function initMultipleDateRanges() {
    const container = document.querySelector(".jp-date-range-container");
    const addButton = document.getElementById("addDateRange");

    if (!container || !addButton) return;

    // Add a new date range when clicking the add button
    addButton.addEventListener("click", function () {
        addDateRange(container);
    });

    // Add event listeners to the initial remove button
    const initialRemoveBtn = container.querySelector(".jp-remove-date-range");
    if (initialRemoveBtn) {
        initialRemoveBtn.addEventListener("click", function () {
            // Don't remove if it's the only date range
            if (container.querySelectorAll(".jp-date-range").length > 1) {
                this.closest(".jp-date-range").remove();
            }
        });
    }
}

/**
 * Adds a new date range input to the container
 */
function addDateRange(container) {
    const newRange = document.createElement("div");
    newRange.className = "jp-date-range mb-3";
    newRange.innerHTML = `
        <div class="row">
            <div class="col-md-5">
                <div class="jp-input-wrapper">
                    <input type="date" class="form-control jp-input date-from" 
                        name="date_from[]" value="">
                    <label class="jp-small-text">開始日</label>
                </div>
            </div>
            <div class="col-md-2 text-center py-2">
                <span class="jp-date-separator">～</span>
            </div>
            <div class="col-md-5">
                <div class="jp-input-wrapper">
                    <input type="date" class="form-control jp-input date-to" 
                        name="date_to[]" value="">
                    <label class="jp-small-text">終了日</label>
                </div>
            </div>
        </div>
        <button type="button" class="btn btn-sm jp-btn-icon jp-remove-date-range">
            <i class="fas fa-times"></i>
        </button>
    `;

    container.appendChild(newRange);

    // Add event listener to the new remove button
    const removeBtn = newRange.querySelector(".jp-remove-date-range");
    removeBtn.addEventListener("click", function () {
        newRange.remove();
    });
}

/**
 * Sets up the advanced search form submission
 */
function setupAdvancedSearchForm() {
    const form = document.getElementById("advancedSearchForm");

    if (form) {
        form.addEventListener("submit", function (event) {
            const query = document.getElementById("query");
            let isValid = true;

            // Clear previous error messages
            document.querySelectorAll(".jp-error-message").forEach((el) => {
                el.remove();
            });

            // Query validation
            if (!query.value || query.value.length < 2) {
                isValid = false;
                const errorMessage = document.createElement("span");
                errorMessage.className = "jp-error-message";
                errorMessage.textContent =
                    "検索キーワードは2文字以上で入力してください。";
                query.parentNode.after(errorMessage);
            }

            // Update all multi-select elements
            document
                .querySelectorAll(".jp-multiselect-wrapper")
                .forEach((wrapper) => {
                    const select = wrapper.querySelector("select");
                    updateOriginalSelect(select, wrapper);
                });

            if (!isValid) {
                event.preventDefault();
            }
        });
    }
}
