# instruction.md

# Instructions for Qwen Coder

## Objective

Generate a complete, production-ready WordPress CMS + WooCommerce
website based on the Foodieland design and the accompanying
`requirements.md`.

## General Rules

-   Read `requirements.md` completely before generating code.
-   Do not skip any feature.
-   Do not generate placeholder-only implementations.
-   Every page must be dynamic.
-   Do not use Elementor, WPBakery, or any page builder.
-   Build a custom WordPress theme.

## Development Order

1.  Create the project folder structure.
2.  Configure WordPress theme.
3.  Configure WooCommerce support.
4.  Create reusable components.
5.  Build global layouts (Header/Footer).
6.  Create Custom Post Types.
7.  Register Taxonomies.
8.  Register Custom Fields.
9.  Build Homepage.
10. Build Recipe pages.
11. Build Blog pages.
12. Build Shop pages.
13. Build Contact/About pages.
14. Build My Account pages.
15. Implement Search.
16. Implement Wishlist & Favorites.
17. Implement AJAX functionality.
18. Implement Newsletter.
19. Add SEO.
20. Optimize performance.
21. Secure inputs and outputs.
22. Test responsiveness.
23. Verify accessibility.
24. Refactor and document.

## Coding Standards

-   Follow WordPress Coding Standards.
-   Use Object-Oriented PHP.
-   Follow SOLID principles.
-   Reuse components.
-   Keep code modular.
-   Sanitize all input.
-   Escape all output.
-   Use nonces for forms.
-   Use prepared SQL statements.
-   Use hooks and filters appropriately.

## UI Guidelines

-   Match the provided Foodieland templates.
-   Preserve spacing, typography, and card styles.
-   Responsive on desktop, tablet, and mobile.
-   Smooth animations and hover effects.
-   Lazy-load images.

## Performance

-   Optimize for Lighthouse 95+.
-   Minify assets.
-   Use responsive WebP images.
-   Load scripts only when required.

## Deliverables

Produce: - Complete WordPress theme - WooCommerce integration - Dynamic
templates - Gutenberg-compatible blocks - Responsive layouts - SEO-ready
implementation - Production-ready code

## Important

Never stop after generating a homepage or a few templates. Continue
until every requirement from `requirements.md` has been implemented. If
the output exceeds the context window, continue from the previous
response until the project is complete.
