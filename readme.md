# PartyTown for WordPress

**PartyTown** is a WordPress plugin that optimizes third-party scripts by offloading them to Web Workers, improving site performance by reducing the main thread load.

## **Plugin Information**

- **Plugin Name**: PartyTown
- **Plugin URI**: [https://www.tamimhasan.com/partytown](https://www.tamimhasan.com/partytown)
- **Description**: A plugin to optimize third-party scripts using PartyTown.
- **Version**: 1.0.0
- **Author**: Md Tamim Hasan
- **Author URI**: [https://www.tamimhasan.com](https://www.tamimhasan.com)
- **License**: GPL2
- **Text Domain**: partytown

## **Features**

- **Script Optimization**: Automatically offloads third-party scripts to Web Workers to reduce main thread blocking and improve page performance.
- **Easy Setup**: Simple activation and deactivation hooks.
- **Custom Path Support**: Enqueues the Partytown library from a custom upload directory.
- **Settings Page**: Enable or disable PartyTown through a simple settings interface in the WordPress admin.
- **Uninstall**: Automatically deletes the Partytown upload directory upon plugin uninstall.

## **Installation**

### 1. Upload Plugin

- Download the plugin ZIP file.
- Go to the WordPress Admin dashboard.
- Navigate to **Plugins** > **Add New**.
- Click **Upload Plugin** and select the ZIP file.
- Install and activate the plugin.

### 2. Manual Installation

- Upload the `partytown` folder to the `/wp-content/plugins/` directory.
- Activate the plugin through the **Plugins** menu in WordPress.

## **Configuration**

Once activated, navigate to the **Partytown** settings page in the WordPress admin to configure the plugin. The settings allow you to enable or disable PartyTown script optimization.

## **Uninstalling the Plugin**

When you uninstall the plugin, the plugin will automatically clean up the Partytown directory that was created on activation. However, you can manually remove it if needed.

## **Support**

For any issues or support, please reach out to [support@tamimhasan.com](mailto:support@tamimhasan.com).

## **Changelog**

### 1.0.0

- Initial release of PartyTown plugin for WordPress.
- Added script optimization for third-party scripts using Web Workers.
