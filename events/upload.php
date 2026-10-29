
<?php
function upload_poster($file) {

    // 1. Poster is optional
    if (empty($file) || $file['error'] == UPLOAD_ERR_NO_FILE) {
        return [null, null];
    }

    // 2. Check PHP upload errors
    if ($file['error'] == UPLOAD_ERR_INI_SIZE ||
        $file['error'] == UPLOAD_ERR_FORM_SIZE) {
        return [null, "File must be 2 MB or less."];
    }

    if ($file['error'] != UPLOAD_ERR_OK) {
        return [null, "Upload failed."];
    }

    // 3. Check file extension
    $ext = strtolower(pathinfo(
        $file['name'],
        PATHINFO_EXTENSION
    ));

    $allowed_types = [
        'jpg'  => 'image/jpeg',
        'jpeg' => 'image/jpeg',
        'png'  => 'image/png',
        'webp' => 'image/webp'
    ];

    if (!isset($allowed_types[$ext])) {
        return [null, "Only JPG, PNG and WEBP files are allowed."];
    }

    // 4. Check file size (maximum 2 MB)
    if ($file['size'] > 2 * 1024 * 1024) {
        return [null, "File must be 2 MB or less."];
    }

    // 5. Validate actual MIME type
    $finfo = new finfo(FILEINFO_MIME_TYPE);
    $mime = $finfo->file($file['tmp_name']);

    if ($mime !== $allowed_types[$ext]) {
        return [null, "Invalid image type. Use JPG, PNG or WEBP."];
    }

    // 6. Confirm that the file is a real image
    if (@getimagesize($file['tmp_name']) === false) {
        return [null, "This file is not a real image."];
    }

    // 7. Create uploads folder if it does not exist
    if (!is_dir('uploads') &&
        !mkdir('uploads', 0755, true)) {
        return [null, "Upload directory could not be created."];
    }

    // 8. Generate a unique filename
    $new_name = bin2hex(random_bytes(16)) . '.' . $ext;

    // 9. Save the uploaded poster
    if (!move_uploaded_file(
        $file['tmp_name'],
        'uploads/' . $new_name
    )) {
        return [null, "Could not save the file."];
    }

    return [$new_name, null];
}
?>
