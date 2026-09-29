# 🔗 URL Parameter Passthrough for CRM Forms and Funnel Links

A lightweight WordPress plugin that carries a visitor's landing URL parameters (UTMs, GCLID, FBCLID and any others) into embedded CRM forms **and** onto links to your funnel pages. It keeps your paid ad leads attributed to the ad that sent them, whichever way they reach your CRM.

Works with **GoHighLevel**, **HubSpot**, **Salesforce Pardot**, and any CRM that embeds forms in an iframe or hosts funnel pages on its own domain.

---

## 💡 The problem: lost attribution

Someone clicks your Google or Meta ad and lands on your WordPress site with `?gclid=...&utm_source=google&...` in the address bar. Two things lose those parameters:

1. **An embedded form.** The form lives in an iframe from your CRM's domain, so it can't see the parent page's URL. The lead arrives with no click ID.
2. **A link to your funnel.** A blog post's call to action sends the reader to a funnel page on another domain (`go.yourdomain.com`), and the parameters stay behind.

Either way:

- **🚫 Lost attribution.** You can't tie the lead back to the ad, so Google and Meta can't learn which ads work.
- **❌ Broken pre-population.** Form fields can't be filled from URL parameters.
- **📉 Wrong reports.** Your CRM's first-touch and multi-touch attribution come up empty or credit the wrong source.

## ✅ What it does

- **Captures every parameter on the landing URL**, except WordPress's own (`p`, `s`, `preview` and similar).
- **Adds them to iframes** whose `src` starts with one of your iframe prefixes, including forms that load late or are lazy-loaded.
- **Adds them to links** whose URL starts with one of your link prefixes, including links added after the page loads.
- **Keeps them for the whole visit**, so a reader who clicks through to a second page before converting still carries them. Stored in `sessionStorage` only, and gone when the tab closes.
- **Never duplicates a parameter.** An incoming value replaces the same-named one already on the iframe or link (the ad's `utm_source` beats a CTA's `utm_source=blog`), and everything else on it is kept.
- **Sends nothing anywhere.** It only rewrites URLs on your own page.

## 🚀 Installation

Pick one:

- **Upload the file:** copy `crm_iframe.php` to `wp-content/mu-plugins/` (always on, no activation needed), or to `wp-content/plugins/` and activate it under Plugins.
- **Upload a zip:** zip `crm_iframe.php`, then go to Plugins → Add New → Upload Plugin, and activate it.

Then clear any page cache, so cached pages pick up the script.

Upgrading from 1.x: replace the file. Same filename, same plugin, and your old `allowedPrefixes` become the iframe prefixes below.

## ⚙️ Configuration

The defaults suit GoHighLevel on a white-labelled domain:

| List | Defaults | Matches |
|---|---|---|
| Iframe prefixes | `https://app.`, `https://api.`, `https://link.` | Embedded forms, surveys and calendars |
| Link prefixes | `https://go.`, `https://link.` | Funnel pages and booking links |

A prefix is the start of a URL. `https://api.` matches `https://api.yourdomain.com/widget/form/...`. To find yours, inspect the embedded form's `src`, or the funnel link's `href`, and copy the start of it.

To change them, either edit the arrays at the top of `crm_iframe.php`, or set them from your theme or another plugin with a filter, so an update to this file doesn't undo your changes:

```php
add_filter( 'sf_passthrough_iframe_prefixes', function ( $prefixes ) {
    $prefixes[] = 'https://forms.mycrm.com/';
    return $prefixes;
} );

add_filter( 'sf_passthrough_link_prefixes', function ( $prefixes ) {
    $prefixes[] = 'https://offers.example.com/';
    return $prefixes;
} );
```

`sf_passthrough_skip_params` changes which parameters are never passed on.

## 🧪 Checking it works

Open any page on your site with test parameters, for example `https://yoursite.com/contact/?gclid=TEST123&utm_source=test`, then inspect the embedded form (its `src`) or a funnel link (its `href`). Both should end with `gclid=TEST123&utm_source=test`.

## 🤝 Contribution

This script is free and open source. Contributions, bug reports and suggestions are welcome.

* Fork the repository.
* Create a new branch (`git checkout -b feature/amazing-feature`).
* Commit your changes (`git commit -m 'Feat: Added amazing feature'`).
* Push to the branch (`git push origin feature/amazing-feature`).
* Open a Pull Request.

## 📄 License

MIT. See the LICENSE file for details.
