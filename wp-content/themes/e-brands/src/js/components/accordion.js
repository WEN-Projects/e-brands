class Accordion {
    /**
     * Constructor for the Accordion class.
     * @param {Object} opts - Options for the accordion.
     */
    constructor(opts) {
        this.options = {
            wrapper: ".accordion",
            item: ".accordion_item",
            head: ".accordion_head",
            body: ".accordion_body",
            closeOtherItems: true,
            ...opts,
        };

        // Get all accordion wrappers
        const wrappers = document.querySelectorAll(this.options.wrapper);

        if (!wrappers.length) return;

        wrappers.forEach((wrapper) => this.initAccordion(wrapper));
    }

    /**
     * Initializes an accordion on a given wrapper element.
     * @param {HTMLElement} wrapper - The wrapper element for the accordion.
     */
    initAccordion(wrapper) {
        const items = Array.from(wrapper.querySelectorAll(this.options.item));
        if (!items.length) return;

        items.forEach((item) => {
            // Get the head and body of the item
            const [head, body] = [this.options.head, this.options.body].map(
                (selector) => item.querySelector(selector)
            );

            if (!head || !body) return;

            window.addEventListener('resize', ()=> {
                this.toggleContent(item, body);
            });

            // Define the click handler for the accordion
            const clickHandler = () => {
                this.toggleAccordion(item);
                this.toggleContent(item, body);
                this.closeOtherItems(items, item);
            };

            head.addEventListener("click", clickHandler);

            head.addEventListener("keydown", (e) => {
                switch (e.key) {
                    case "Enter":
                        clickHandler();
                        break;
                    case "ArrowUp":
                        this.moveUp(items, item);
                        break;
                    case "ArrowDown":
                        this.moveDown(items, item);
                        break;
                    default:
                        break;
                }
            });
        });
    }

    /**
     * Toggles the accordion item state between opened and closed.
     * @param {HTMLElement} accordionItem - The accordion item to toggle.
     */
    toggleAccordion(accordionItem) {
        let isOpened = accordionItem.classList.contains("opened");
        accordionItem.classList.toggle("opened", !isOpened);
    }

    /**
     * Toggles the content of an item.
     *
     * @param {HTMLElement} item - The item to toggle.
     * @param {HTMLElement} content - The content to toggle.
     */
    toggleContent(item, content) {
        let totalHeight = 0;

        if (item.classList.contains("opened")) {
            // Calculate totalHeight by summing up the height of each child
            totalHeight = Array.from(content.children).reduce(
                (sum, child) => sum + child.offsetHeight,
                totalHeight
            );
        }

        // Set the height of the content based on the item's state
        content.style.height = item.classList.contains("opened")
            ? `${totalHeight}px`
            : null;
    }

    /**
     * Closes all items except the active one.
     * @param {Array} items - The list of items to close.
     * @param {HTMLElement} activeItem - The active item to keep open.
     */
    closeOtherItems(items, activeItem) {
        if (!this.options.closeOtherItems) return;

        items.forEach(item => {
            // If the item is not the active one, close it.
            if (item !== activeItem) {
                item.classList.remove("opened");
                item.querySelector(this.options.body).style.height = null;
            }
        })
    }

    /**
     * Moves focus to the previous item in the list of items.
     *
     * @param {Array} items - The list of items.
     * @param {Element} currentItem - The current item.
     */
    moveUp(items, currentItem) {
        // Get the index of the current item
        const idx = items.indexOf(currentItem);

        if (idx > 0) {
            const currentHead = currentItem.querySelector(this.options.head);

            const previousItem = items[idx - 1];
            const previousHead = previousItem.querySelector(this.options.head);

            // blur current item's head set focus to previous item's head
            currentHead.blur();
            previousHead.focus();
        }
    }

    /**
     * Moves the current item down in the list of items.
     *
     * @param {Array} items - The list of items.
     * @param {Object} currentItem - The current item.
     */
    moveDown(items, currentItem) {
        let currentIndex = items.indexOf(currentItem);

        if (currentIndex < items.length - 1) {
            let nextItem = items[currentIndex + 1];

            let currentHead = currentItem.querySelector(this.options.head);
            let nextHead = nextItem.querySelector(this.options.head);

            // Remove focus from the current item's head and set it to the next item's head
            currentHead.blur();
            nextHead.focus();
        }
    }
}

export default Accordion;
