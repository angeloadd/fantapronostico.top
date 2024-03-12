// This is an example file for making components custom
/**
 * <template fp-component="dropdown">
 *     <div x-data="{ ...dropdown(), ...$el.parentElement.data()}">
 *         <button x-on:click="open">Open</button>
 *
 *         <div x-show="isOpen()" x-on:click.away="close" x-text="content"></div>
 *     </div>
 * </template>
 *
 * <fp-dropdown content="Content for my first dropdown"></fp-dropdown>
 *
 * <div> Random stuff... </div>
 *
 * <fp-dropdown content="Content for my second dropdown"></fp-dropdown>
 *
 * <fp-dropdown></fp-dropdown>
 *
 *     <script>
 *         function dropdown() {
 *             return {
 *                 show: false,
 *                 open() { this.show = true },
 *                 close() { this.show = false },
 *                 isOpen() { return this.show === true },
 *                 content: 'Default content'
 *             }
 *         }
 *     </script>
 * */
// document.querySelectorAll("[fp-component]").forEach((component) => {
// 	const componentName = `fp-${component.getAttribute("fp-component")}`;
// 	class Component extends HTMLElement {
// 		connectedCallback() {
// 			this.append(component.content.cloneNode(true));
// 		}
//
// 		data() {
// 			const attributes = this.getAttributeNames();
// 			const data = {};
// 			attributes.forEach((attribute) => {
// 				data[attribute] = this.getAttribute(attribute);
// 			});
// 			return data;
// 		}
// 	}
// 	customElements.define(componentName, Component);
// });
