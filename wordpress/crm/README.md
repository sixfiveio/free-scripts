# 🔗 Iframe Parameter Passthrough Script

A lightweight, vendor-agnostic JavaScript utility to automatically pass parent window URL parameters (like UTMs, GCLID, and FBID) into specified iframe sources. Essential for fixing attribution tracking and form pre-population issues caused by cross-domain iframe embedding.

---

## 💡 The Problem: Lost Attribution Data

When a form (or other content) from a third-party CRM (like **GoHighLevel**, **Pardot**, **HubSpot**, **Salesforce**, etc.) is embedded on your main website using an **iframe**, critical URL parameters are often lost.

This means:

1.  **🚫 Lost Attribution:** You cannot reliably attribute form submissions to your **Google Ads (GCLID)** or **Facebook/Meta Ads (FBID)** campaigns.
2.  **❌ Broken Pre-Population:** Form fields cannot be automatically pre-populated using URL parameters for a seamless user experience.
3.  **📉 Inaccurate Reporting:** Your CRM's first-touch and multi-touch attribution reports (like GoHighLevel's first-action attribution) become incomplete or incorrect.

## ✅ The Solution: Seamless Parameter Injection

This script solves the problem by inspecting every iframe on the page and, if its `src` URL matches one of the specified allowed prefixes, it automatically appends all parameters from the parent window's URL to the iframe's `src`.

## 🚀 Installation & Usage

### Configuration
The key to this script's flexibility is the `allowedPrefixes` array.

To ensure your script only modifies iframes that belong to your CRM (and not others like YouTube, Calendly, etc.), you must list the starting URL prefixes of your CRM's embedded content.
```
const allowedPrefixes = [
    'https://app.',
    'https://api.',
    // ADD YOUR OWN HERE 
];
```
To Add a New Prefix:

* Inspect the src attribute of your embedded form/content.
* Add the unique starting part of that URL (usually the domain and protocol) to the allowedPrefixes array.

Example: If your iframe's src is https://forms.mycrm.com/embed/12345, you should add 'https://forms.mycrm.com/' to the array.

## 🤝 Contribution
This script is provided free and open-source to the community. We welcome contributions, bug reports, and suggestions for improvement!

* Fork the repository.
* Create a new branch (git checkout -b feature/amazing-feature).
* Commit your changes (git commit -m 'Feat: Added amazing feature').
* Push to the branch (git push origin feature/amazing-feature).
* Open a Pull Request.

## 📄 License
This project is licensed under the MIT License. See the LICENSE file for details.
