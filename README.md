# Rezon8 Child Theme

Twenty Twenty-Five child theme for **Rezon8 Media & Marketing Services**, built with Google Material Design 3 principles.

## Stack

- **Parent theme:** Twenty Twenty-Five (WordPress FSE)
- **Design system:** Material Design 3 (CSS custom properties, no external library)
- **Fonts:** Roboto + Roboto Mono via Google Fonts
- **Hosting:** Go High Level WordPress hosting
- **Local dev:** Local by Flywheel

## Structure

```
rezon8-child/
├── style.css           # Theme declaration + CSS custom properties (brand tokens)
├── functions.php       # Enqueue styles/scripts, setup, utilities
├── theme.json          # Block editor color palette, typography, spacing
├── assets/
│   ├── css/
│   │   ├── material.css    # Material Design component overrides
│   │   └── editor.css      # Gutenberg editor styles
│   ├── js/
│   │   └── main.js         # Ripple effects, sticky header, smooth scroll
│   ├── fonts/              # Self-hosted font files (if needed)
│   └── images/             # Theme images / icons
└── inc/                    # Additional PHP includes (template tags, etc.)
```

## Local Development

1. Install [Local by Flywheel](https://localwp.com/)
2. Create a new site or pull from GHL hosting
3. Place this folder in `wp-content/themes/rezon8-child/`
4. Activate **Rezon8 Child** in WordPress → Appearance → Themes

## Deployment to GHL Hosting

1. Zip the theme folder: `zip -r rezon8-child.zip rezon8-child/`
2. Upload via WordPress Admin → Appearance → Themes → Add New → Upload
3. Or use SFTP/SSH credentials from GHL hosting panel

## Brand Tokens

All brand colors and design tokens are defined as CSS custom properties in `style.css`:

| Token | Value | Use |
|---|---|---|
| `--r8-primary` | `#0D47A1` | Buttons, links, accents |
| `--r8-secondary` | `#00BCD4` | Highlights, badges |
| `--r8-surface` | `#FAFAFA` | Cards, panels |
| `--r8-on-surface` | `#1A1A1A` | Body text |

## GitHub

Repo: `git@github.com:f4d/rezon8-child.git`
