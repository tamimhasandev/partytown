=== PartyTown for WordPress ===
Contributors: Tamim Hasan
Tags: performance, optimization, web workers, third-party scripts, Google Analytics, Google Tag Manager
Requires at least: 5.0
Tested up to: 6.0
Stable tag: 1.0.0
License: GPL2
License URI: http://www.gnu.org/licenses/gpl-2.0.html

== Description ==

**PartyTown** is a performance-boosting WordPress plugin that offloads third-party scripts to web workers, improving site speed and reducing load times. With a simple toggle in the settings, you can enable or disable the Partytown library to optimize scripts like Google Analytics, Google Tag Manager, and more—without writing any code.

== Features ==

- **Script Optimization**: Automatically offloads third-party scripts to Web Workers, reducing main thread blocking and improving page performance.
- **Easy Setup**: Toggle the Partytown library on or off via the plugin's settings interface.
- **Settings Page**: Simple, intuitive settings page in the WordPress admin to configure the plugin.
- **Uninstall**: Automatically deletes the Partytown upload directory upon plugin uninstall.

== Installation ==

1. Upload Plugin

- Download the plugin ZIP file.
- Go to the WordPress Admin dashboard.
- Navigate to **Plugins** > **Add New**.
- Click **Upload Plugin** and select the ZIP file.
- Install and activate the plugin.

2. Manual Installation

- Upload the `partytown` folder to the `/wp-content/plugins/` directory.
- Activate the plugin through the **Plugins** menu in WordPress.

== How to Use ==

1. **Enable PartyTown**:

- Go to the WordPress admin dashboard.
- Navigate to **Settings > PartyTown**.
- In the **General Settings** section, check the box to **Enable PartyTown Library**.
- Save your settings.

2. **Use `type='text/partytown'` in Your Scripts**:

After enabling PartyTown, update your third-party script tags to use the `type="text/partytown"` attribute. This will offload the scripts to web workers, reducing their impact on the main thread and improving website performance.

Example: Google Tag Manager with Google Analytics

```html
<script type="text/partytown">
  (function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
  new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
  j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
  'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
  })(window,document,'script','dataLayer','GTM-XXXX');
</script>

<script type="text/partytown">
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-XXXXXXX-X');  // Replace with your Google Analytics ID
</script>
By using type="text/partytown", PartyTown offloads these scripts to web workers, enabling them to run in the background without blocking the main thread. This results in faster page load times and improved performance.

== Uninstalling the Plugin ==
To uninstall the plugin:
 - Navigate to the Plugins section in WordPress.
 - Deactivate and delete the PartyTown plugin. 
 - The plugin will automatically remove the Partytown upload directory created during activation. However, if you need to remove it manually, you can do so from the file system.

== Support ==
If you encounter any issues or need support, please reach out to us at support@tamimhasan.com.

== Changelog ==

= 1.0.0 =
- Initial release of the PartyTown plugin for WordPress.
- Added script optimization for third-party scripts using Web Workers.
