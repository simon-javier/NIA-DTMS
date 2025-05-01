# Project Setup

## Prerequisites
Before editing this project, ensure you have Tailwind CSS installed.

## Installation
1. Install Tailwind CSS and the CLI:
   ```sh
   npm install tailwindcss @tailwindcss/cli
   ```
   
2. Import Tailwind in your CSS file (e.g., `input.css`):
   ```css
   @import "tailwindcss";
   ```

3. Start the Tailwind CLI build process:
   ```sh
   npx @tailwindcss/cli -i ./assets/css/input.css -o ./assets/css/output.css --watch
   ```

## Usage
1. Link the compiled CSS file in your HTML *(if it is not already linked)*:
   ```html
   <link href="./assets/css/output.css" rel="stylesheet">
   ```

2. Start using Tailwind utility classes in your HTML.

## Notes
- Ensure that Tailwind CSS is correctly installed before editing.
- Refer to the [Tailwind CSS documentation](https://tailwindcss.com/docs/installation/tailwind-cli) for advanced configurations.

