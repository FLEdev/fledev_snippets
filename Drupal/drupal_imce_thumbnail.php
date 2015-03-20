// 1. create a image style for a small thumbnail image - "/admin/config/media/image-styles/add" > scale & crop, size ~ 80x50


// 2. put the following markup into  modules/contrib/imce/tpl/imce-file-list.tpl.php
<table id="file-list" class="files">
    <tbody><?php
    if ($imce['perm']['browse'] && !empty($imce['files'])) {
        foreach ($imce['files'] as $name => $file) {
            ?>
        <tr id="<?php print $raw = rawurlencode($file['name']); ?>">
            <td class="name"><?php print $raw; ?></td>
            <!-- !!! thumbnail line -->
            <td class="thumbnail"><img
                    src="<?php print image_style_url('imce', 'public://' . $imce['dir'] . '/' . $file['name']); ?>"
                    alt="<?php print $file['name']; ?>"/></td>
            <!-- !!! /thumbnail line -->
            <td class="size" id="<?php print $file['size']; ?>"><?php print format_size($file['size']); ?></td>
            <td class="width"><?php print $file['width']; ?></td>
            <td class="height"><?php print $file['height']; ?></td>
            <td class="date" id="<?php print $file['date']; ?>"><?php print format_date($file['date'], 'short'); ?></td>
            </tr><?php
        }
    }?>
    </tbody>
</table>
