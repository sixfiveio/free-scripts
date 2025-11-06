# Consent Management with Termageddon, UserCentrics and Google Consent Mode v2
## 📝 Overview
This WordPress plugin provides a robust and compliant integration solution for modern privacy requirements.

It is specifically engineered to work seamlessly with Usercentrics Consent Management Platform (CMP), [Termageddon](https://go.sixfive.io/termageddon), and Google Tag Manager (GTM) Consent Mode v2.

The plugin ensures that your Usercentrics scripts are loaded correctly and that Google Tag Manager is initialized appropriately to handle consent signals and manage all subsequent marketing and analytics tags.

You can get UserCentrics CMP via [Termageddon](https://go.sixfive.io/termageddon) direct (affiliate link), or you can engage SixFive to do the setup and installation for you [Legals for your Website](https://sixfive.io/products/wordpress/legals/) 

## ✨ Features
Optimal Script Loading: Preloads and inserts the necessary Usercentrics uc-block.bundle.js script high in the <head> for maximum speed and compliance.

Termageddon Translation Support: Automatically configures Usercentrics to use custom translations hosted by Termageddon.

GTM Consent Mode v2 Ready: Explicitly excludes the Google Tag Manager container script from Usercentrics' automatic blocking mechanism, enabling GTM to control consent mode and manage tags based on user choice. [How to configure your GTM](https://github.com/sixfiveio/free-scripts/tree/main/gtm) 

DoubleClick Ad (DFP) Support: Automatically modifies common DoubleClick Ad script handles (jquery_dfp and google_dfp) to include the required data-usercentrics attribute, ensuring ad scripts are only loaded after the necessary consent is given.

## ⚙️ Installation
* Download: Download the latest release ZIP file of this repository.
* Upload: Go to your WordPress Admin Dashboard -> Plugins -> Add New -> Upload Plugin.
* Activate: Select the downloaded ZIP file and click "Install Now," then "Activate Plugin."

The plugin is now active and the core Usercentrics script has been added to your website's <head>.

## 🤝 Contributing
We welcome contributions! If you have suggestions for improvements, feature requests, or bug reports, please open an Issue on this repository.

## 📄 License
This project is licensed under the MIT License. See the LICENSE.md file for details.
