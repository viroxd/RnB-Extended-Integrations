jQuery(document).ready(function($) {
    // Settings Export
    $('#rnb-export-settings-btn').on('click', function(e) {
        e.preventDefault();
        
        console.log('RnB Debug: Settings export button clicked');
        
        const button = $(this);
        const originalText = button.text();
        button.text('Exporting...').prop('disabled', true);
        
        const nonce = $('#rnb-settings-export-form input[name="nonce"]').val();
        console.log('RnB Debug: Settings export nonce:', nonce);
        
        $.ajax({
            url: rnb_export_import_data.ajax_url,
            type: 'POST',
            data: {
                action: 'rnb_export_settings',
                nonce: $('#rnb-settings-export-form input[name="nonce"]').val()
            },
            success: function(response) {
                console.log('RnB Debug: Settings export response:', response);
                if (response.success) {
                    // Create and download file
                    var dataStr = JSON.stringify(response.data, null, 2);
                    var dataBlob = new Blob([dataStr], {type: 'application/json'});
                    var url = window.URL.createObjectURL(dataBlob);
                    var link = document.createElement('a');
                    link.href = url;
                    link.download = 'rnb-settings-' + new Date().toISOString().slice(0,10) + '.json';
                    link.click();
                    window.URL.revokeObjectURL(url);
                    
                    $('#rnb-export-result').html('<div class="notice notice-success"><p>Settings exported successfully!</p></div>');
                } else {
                    $('#rnb-export-result').html('<div class="notice notice-error"><p>' + (response.data.message || 'Export failed.') + '</p></div>');
                }
            },
            error: function(xhr, status, error) {
                console.log('RnB Debug: Settings export error:', {xhr: xhr, status: status, error: error});
                $('#rnb-export-result').html('<div class="notice notice-error"><p>Export failed. Please try again.</p></div>');
            },
            complete: function() {
                button.text(originalText).prop('disabled', false);
            }
        });
    });

    // Settings Import
    $('#rnb-import-settings-form').on('submit', function(e) {
        e.preventDefault();
        
        var formData = new FormData(this);
        formData.append('action', 'rnb_import_settings');
        formData.append('rnb_import_settings_nonce', $('#rnb-import-settings-form input[name="rnb_import_settings_nonce"]').val());
        
        $('#rnb-import-settings-btn').prop('disabled', true).text('Importing...');
        
        $.ajax({
            url: rnb_export_import_data.ajax_url,
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                console.log('RnB Debug: Settings import response:', response);
                if (response.success) {
                    $('#rnb-settings-import-result').html('<div class="notice notice-success"><p>' + (response.data.message || 'Settings imported successfully!') + '</p></div>');
                } else {
                    $('#rnb-settings-import-result').html('<div class="notice notice-error"><p>' + (response.data.message || 'Import failed.') + '</p></div>');
                }
            },
            error: function(xhr, status, error) {
                console.log('RnB Debug: Settings import error:', {xhr: xhr, status: status, error: error});
                $('#rnb-settings-import-result').html('<div class="notice notice-error"><p>Import failed. Please try again.</p></div>');
            },
            complete: function() {
                $('#rnb-import-settings-btn').prop('disabled', false).text('Import Settings');
            }
        });
    });

    // Inventory Export
    $('#rnb-export-inventory-btn').on('click', function(e) {
        e.preventDefault();
        
        console.log('RnB Debug: Inventory export button clicked');
        
        const button = $(this);
        const originalText = button.text();
        button.text('Exporting...').prop('disabled', true);
        
        const nonce = $('#rnb-inventory-export-form input[name="nonce"]').val();
        console.log('RnB Debug: Nonce value:', nonce);
        
        $.ajax({
            url: rnb_export_import_data.ajax_url,
            type: 'POST',
            data: {
                action: 'rnb_export_inventory_csv',
                nonce: nonce
            },
            success: function(response) {
                console.log('RnB Debug: AJAX response:', response);
                if (response.success) {
                    // Create and download CSV file
                    const csvContent = response.data.csv_content;
                    const filename = response.data.filename;
                    const blob = new Blob([csvContent], { type: 'text/csv;charset=utf-8;' });
                    const link = document.createElement('a');
                    if (link.download !== undefined) {
                        const url = URL.createObjectURL(blob);
                        link.setAttribute('href', url);
                        link.setAttribute('download', filename);
                        link.style.visibility = 'hidden';
                        document.body.appendChild(link);
                        link.click();
                        document.body.removeChild(link);
                    }
                    
                    $('#rnb-inventory-export-result').html('<div class="notice notice-success"><p>Inventories exported successfully!</p></div>');
                } else {
                    $('#rnb-inventory-export-result').html('<div class="notice notice-error"><p>' + (response.data.message || 'Export failed.') + '</p></div>');
                }
            },
            error: function(xhr, status, error) {
                console.log('RnB Debug: AJAX error:', {xhr: xhr, status: status, error: error});
                $('#rnb-inventory-export-result').html('<div class="notice notice-error"><p>Export failed. Please try again.</p></div>');
            },
            complete: function() {
                button.text(originalText).prop('disabled', false);
            }
        });
    });

    // Inventory Import
    $('#rnb-inventory-import-form').on('submit', function(e) {
        e.preventDefault();
        
        const fileInput = $('input[name="rnb_inventory_file"]');
        if (fileInput[0].files.length === 0) {
            alert('Please select a file to import.');
            return;
        }
        
        const file = fileInput[0].files[0];
        const fileExt = file.name.split('.').pop().toLowerCase();
        
        if (fileExt !== 'csv') {
            alert('Please upload a valid .csv file.');
            return;
        }
        
        const formData = new FormData();
        formData.append('action', 'rnb_import_inventory_csv');
        formData.append('rnb_inventory_file', file);
        formData.append('nonce', $('#rnb-inventory-import-form input[name="nonce"]').val());
        
        // Show loading indicator
        const importButton = $('#rnb-import-inventory-btn');
        const originalText = importButton.text();
        importButton.text('Importing...').prop('disabled', true);
        
        $.ajax({
            url: rnb_export_import_data.ajax_url,
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                if (response.success) {
                    $('#rnb-inventory-import-result').html('<div class="notice notice-success"><p>' + (response.data.message || 'Inventories imported successfully!') + '</p></div>');
                    
                    // Show errors if any
                    if (response.data.errors && response.data.errors.length > 0) {
                        let errorHtml = '<div class="notice notice-warning"><p><strong>Errors occurred:</strong></p><ul>';
                        response.data.errors.forEach(function(error) {
                            errorHtml += '<li>' + error + '</li>';
                        });
                        errorHtml += '</ul></div>';
                        $('#rnb-inventory-import-result').append(errorHtml);
                    }
                } else {
                    $('#rnb-inventory-import-result').html('<div class="notice notice-error"><p>' + (response.data.message || 'Import failed.') + '</p></div>');
                }
            },
            error: function() {
                $('#rnb-inventory-import-result').html('<div class="notice notice-error"><p>Import failed. Please try again.</p></div>');
            },
            complete: function() {
                importButton.text(originalText).prop('disabled', false);
                fileInput.val(''); // Clear file input
            }
        });
    });
});