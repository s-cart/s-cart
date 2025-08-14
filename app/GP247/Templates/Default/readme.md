# Create a new Template

To create a new template, use the following artisan command:

```bash
php artisan gp247:make-template --name=YourTemplateName --download=0
```

Where:
- `YourTemplateName`: Your template name
- `--download=0`: Create the template directly under `app/GP247/Templates`
- `--download=1`: Create a template zip file under `storage/tmp`

# GP247 Template Structure

This is the standard format for developing templates in the GP247 system.

## Directory structure

```
template/
├── blocks/         # Reusable UI blocks (partials) used by the template
├── Lang/           # Language files
├── Plugins/        # Optional extensions bundled with the template
├── public/         # Public assets (css, js, images). During install, they are copied to public/GP247/Templates/{template}
├── AppConfig.php   # Main configuration of the template
├── config.php      # Display/options configuration of the template
├── function.php    # Helper functions used in the template
├── gp247.json      # Template metadata declaration
├── Provider.php    # Service provider of the template
└── Route.php       # Template route declarations
```

## Component descriptions

### 1. gp247.json
Declare the basic information of the template:
- name: Template name
- image: Template logo
- auth: Author
- configGroup: Configuration group (for Template: "Templates")
- configCode: Configuration code
- configKey: Configuration key (unique, matches the template folder name)
- version: Version
- requireCore: Compatible Gp247/Core version
- requirePackages: Required packages (default `gp247/front`)
- requireExtensions: Names of required extensions (plugins, templates)

### 2. AppConfig.php
Contains the template lifecycle methods:
- install(), uninstall(), enable(), disable()
- setupStore(), removeStore()
- clickApp(), getInfo()

### 3. Provider.php
Registers the necessary services, events, and middleware for the template.

### 4. Route.php
Declares the template's frontend routes.

### 5. blocks/
Contains shared UI components (e.g., header, footer, breadcrumb, product lists, ...).

### 6. Plugins/
Place for optional extensions shipped with the template (not required). Each plugin follows the GP247 extension standard.

### 7. public/
Contains the template's static assets (css, js, images). Upon installation, they are published to `public/GP247/Templates/{template}`.

## How to use

1. Initialize:
   - Rename the folder to your template name (matches `configKey`)
   - Update the information in `gp247.json`

2. Develop:
   - Declare routes in `Route.php`
   - Build UI in `blocks/` and subdirectories as needed
   - Write helpers in `function.php`
   - Add languages in `Lang/`
   - Add assets in `public/`

3. Install:
   - Refer to the detailed guide: [English guide](https://gp247.net/en/docs/user-guide-extension/guide-to-installing-the-extension.html) | [Tiếng Việt](https://gp247.net/vi/docs/user-guide-extension/guide-to-installing-the-extension.html)

## Notes

- Use proper namespaces
- Ensure multi-language support
- Check dependencies before installation
- Handle errors and perform rollback when necessary
- Ensure responsive design and page performance

---