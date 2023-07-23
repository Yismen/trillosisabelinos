/**
 * Apply active or a different given class to links based on what item is in view.
 *
 * @param {string} observable_selector Selector to target all the observable items.
 * @param {string} links_selector Selector to target all links to be applied with the class_name.
 * @param {string} class_name Name of the class to be applied to the links
 * @param {double} threshold Number between 0 and 1 representing the percentage of the observable that needs to be in view to trigger the observation.
 */
let NavlinkObserver = function (observable_selector, links_selector, class_name = 'active', threshold = 0.5) {
    const links = document.querySelectorAll(links_selector);
    const sections = document.querySelectorAll(observable_selector);

    const linkObserver = new IntersectionObserver(entries => {
        entries.forEach(entry => {

            if (entry.isIntersecting) {

                let entry_id = entry.target.id;

                links.forEach(link => {
                    entry_id === link.href.split("#")[1] ?
                        link.classList.add(class_name) :
                        link.classList.remove(class_name);
                });
            }
        });
    }, {
        threshold
    });

    sections.forEach(section => {
        linkObserver.observe(section);
    });
}

export default NavlinkObserver;
