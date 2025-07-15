# Bulk Edit Question Category for LearnDash

[![License: GPL v2](https://img.shields.io/badge/License-GPL%20v2-blue.svg)](https://www.gnu.org/licenses/gpl-2.0)
[![WordPress Plugin Compatible](https://img.shields.io/badge/WordPress-Compatible-green.svg)](https://wordpress.org/)
[![LearnDash Compatible](https://img.shields.io/badge/LearnDash-Compatible-orange.svg)](https://www.learndash.com/)

A WordPress plugin that enables bulk editing of question categories in LearnDash LMS, saving course creators and administrators valuable time when managing large sets of quiz questions.

## Description

The **Bulk Edit Question Category for LearnDash** plugin extends the WordPress bulk edit functionality to allow course creators and administrators to assign categories to multiple LearnDash questions simultaneously. This plugin addresses a significant workflow bottleneck in the LearnDash LMS platform by eliminating the need to edit questions individually when organizing them into categories.

### Key Features

- **Bulk Category Assignment**: Update the category for multiple LearnDash questions in a single operation
- **Seamless Integration**: Works directly within the WordPress admin interface in the questions list view
- **User-Friendly Interface**: Simple dropdown menu with all available question categories
- **Success Notifications**: Clear feedback on how many questions were successfully updated
- **Time-Saving**: Dramatically reduces the time needed to organize and categorize quiz questions

## Installation

1. Upload the `bulk-edit-question-category-for-learndash` folder to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Ensure LearnDash LMS is installed and activated

## Requirements

- WordPress 5.0 or higher
- LearnDash LMS 3.0 or higher
- PHP 7.0 or higher

## Usage

1. Navigate to **LearnDash LMS > Questions** in your WordPress admin dashboard
2. Select the questions you want to update by checking the boxes next to them
3. Click the **Bulk Actions** dropdown and select **Edit**
4. In the bulk edit panel that appears, locate the **Category** dropdown
5. Select the desired category from the dropdown menu
6. Click **Update** to apply the changes to all selected questions
7. A success message will display showing how many questions were updated

## Screenshots

1. **Bulk Edit Interface**: The category dropdown added to the bulk edit panel
2. **Success Notification**: Confirmation message after successful category updates

## Frequently Asked Questions

### Does this plugin work with regular WordPress categories?

No, this plugin specifically works with LearnDash's ProQuiz question categories, not standard WordPress taxonomies.

### Can I assign multiple categories to questions at once?

No, LearnDash questions can only belong to one category at a time. This plugin allows you to set that single category for multiple questions simultaneously.

### Will this plugin affect other custom fields in the bulk edit panel?

No, this plugin only adds the category dropdown and does not interfere with other bulk edit functionality.

## Support

For support requests or feature suggestions, please use the [GitHub issues page](https://github.com/j2machado/bulk-edit-question-category-for-learndash/issues) or contact the author at [https://obijuan.dev](https://obijuan.dev).

## Changelog

### 1.0.0
* Initial release

## Credits

Developed by [Obi Juan Dev](https://obijuan.dev)

## License

This plugin is licensed under the GPL v2 or later.

```
This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License, version 2, as
published by the Free Software Foundation.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA 02110-1301 USA
```
