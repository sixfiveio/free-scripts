# Google Consent Mode v2 + UserCentrics CMP v3 + Termageddon Policies + Microsoft Clarity in Cookieless Mode

Video: 

## Required platforms 
Google Tag Manager: [tagmanager.google.com](https://tagmanager.google.com)

Google Analytics: [analytics.google.com](https://analytics.google.com)

Microsoft Clarity: [clarity.microsoft.com](https://clarity.microsoft.com)

Termageddon: [Do It Yourself with 10% off your first year](https://go.sixfive.io/termageddon) OR [SixFive guided concierge set up and configuration](https://sixfive.io/products/wordpress/legals/) (we'll take care of configuration with you, and installation for you).

## Microsoft Clarity Configuration

Settings > Setup > Cookies = OFF

## Google Tag Manager Configuration
GTM Container to import [https://github.com/65/free-scripts/blob/main/gtm/consent_mode_v2.json](https://github.com/65/free-scripts/blob/main/gtm/consent_mode_v2.json) 
- Click on Raw
- File Save as
- Account > Container > Import Container 

** Be careful to choose merge not overwrite if you are using an existing container. ** 

Go to Variables and enter the real IDs for: 
- GA4 Data Stream from [analytics.google.com](https://analytics.google.com) 
- Microsoft Clarity Project ID from [clarity.microsoft.com](https://clarity.microsoft.com) 
- UserCentrics Setting ID from the embed code in Termageddon 
Publish the container

## Website Configuration

### Google Tag Manager 
Pop the GTM embed code on to your website according to instructions from tagmanager.google.com 

If you use Wordpress we recommend [GTM4WP by Thomas Geiger](https://wordpress.org/plugins/duracelltomi-google-tag-manager/) 

### User Centrics scripts

If you use Wordpress we have bundled together the code into a [Must Use plugin 'privacy.php'](https://github.com/sixfiveio/free-scripts/tree/main/wordpress/usercentrics) download this and upload it into your /wp-content/mu-plugins directory. 

Just ** Above** your GTM script insert the following, this allows UserCentrics to fire before GTM and alows UserCentrics to have visibility and control of other javascript. 
```
<link rel="preconnect" href="//privacy-proxy.usercentrics.eu"> <link rel="preload" href="//privacy-proxy.usercentrics.eu/latest/uc-block.bundle.js" as="script"> 
<script type="application/javascript" src="https://privacy-proxy.usercentrics.eu/latest/uc-block.bundle.js"></script>
<!-- Termageddon.com Specific -->
<script>uc.setCustomTranslations('https://termageddon.ams3.cdn.digitaloceanspaces.com/translations/');</script>
<!-- User Centrics - Ignore Blocking for GTM -->
<script>
 uc.deactivateBlocking([
  'BJ59EidsWQ', // GTM is not blocked
 ]);
</script>
```
