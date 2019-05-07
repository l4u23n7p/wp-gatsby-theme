<?php
/**
 * Custom fields for project post type
 */
function add_project_field_group()
{
    if( function_exists( 'acf_add_local_field_group' ) ) {

        acf_add_local_field_group(
            array(
                'key' => 'group_5c3a00c425e00',
                'title' => 'Project Metadata',
                'fields' => array(
                    array(
                        'key' => 'field_5c3a0190aef9b',
                        'label' => 'Informations',
                        'name' => 'informations',
                        'type' => 'group',
                        'instructions' => 'Détails du projet',
                        'required' => 1,
                        'conditional_logic' => 0,
                        'wrapper' => array(
                            'width' => '',
                            'class' => '',
                            'id' => '',
                        ),
                        'layout' => 'block',
                        'sub_fields' => array(
                            array(
                                'key' => 'field_5cba286522e77',
                                'label' => 'Date',
                                'name' => 'date',
                                'type' => 'text',
                                'instructions' => 'Date de réalisation du projet',
                                'required' => 1,
                                'conditional_logic' => 0,
                                'wrapper' => array(
                                    'width' => '',
                                    'class' => '',
                                    'id' => '',
                                ),
                                'default_value' => '',
                                'placeholder' => '',
                                'prepend' => '',
                                'append' => '',
                                'maxlength' => '',
                            ),
                            array(
                                'key' => 'field_5cba28e422e78',
                                'label' => 'Contributors',
                                'name' => 'contributors',
                                'type' => 'repeater',
                                'instructions' => 'Contributeurs du projet',
                                'required' => 1,
                                'conditional_logic' => 0,
                                'wrapper' => array(
                                    'width' => '',
                                    'class' => '',
                                    'id' => '',
                                ),
                                'collapsed' => 'field_5cba292f22e79',
                                'min' => 1,
                                'max' => 0,
                                'layout' => 'row',
                                'button_label' => '',
                                'sub_fields' => array(
                                    array(
                                        'key' => 'field_5cba292f22e79',
                                        'label' => 'Name',
                                        'name' => 'name',
                                        'type' => 'text',
                                        'instructions' => '',
                                        'required' => 1,
                                        'conditional_logic' => 0,
                                        'wrapper' => array(
                                            'width' => '',
                                            'class' => '',
                                            'id' => '',
                                        ),
                                        'default_value' => '',
                                        'placeholder' => '',
                                        'prepend' => '',
                                        'append' => '',
                                        'maxlength' => '',
                                    ),
                                    array(
                                        'key' => 'field_5cba294322e7a',
                                        'label' => 'Link',
                                        'name' => 'link',
                                        'type' => 'url',
                                        'instructions' => '',
                                        'required' => 0,
                                        'conditional_logic' => 0,
                                        'wrapper' => array(
                                            'width' => '',
                                            'class' => '',
                                            'id' => '',
                                        ),
                                        'default_value' => '',
                                        'placeholder' => '',
                                    ),
                                ),
                            ),
                            array(
                                'key' => 'field_5cba29e22e968',
                                'label' => 'Scope',
                                'name' => 'scope',
                                'type' => 'text',
                                'instructions' => 'Cadre de réalisation',
                                'required' => 1,
                                'conditional_logic' => 0,
                                'wrapper' => array(
                                    'width' => '',
                                    'class' => '',
                                    'id' => '',
                                ),
                                'default_value' => '',
                                'placeholder' => '',
                                'prepend' => '',
                                'append' => '',
                                'maxlength' => '',
                            ),
                        ),
                    ),
                    array(
                        'key' => 'field_5c3a01baaef9c',
                        'label' => 'Description',
                        'name' => 'description',
                        'type' => 'wysiwyg',
                        'instructions' => 'Description du projet',
                        'required' => 1,
                        'conditional_logic' => 0,
                        'wrapper' => array(
                            'width' => '',
                            'class' => '',
                            'id' => '',
                        ),
                        'default_value' => '',
                        'tabs' => 'visual',
                        'toolbar' => 'full',
                        'media_upload' => 1,
                        'delay' => 0,
                    ),
                    array(
                        'key' => 'field_5c3a01f8aef9d',
                        'label' => 'Stack',
                        'name' => 'stack',
                        'type' => 'repeater',
                        'instructions' => 'Outils / Technologies utilisés lors du projet',
                        'required' => 1,
                        'conditional_logic' => 0,
                        'wrapper' => array(
                            'width' => '',
                            'class' => '',
                            'id' => '',
                        ),
                        'collapsed' => 'field_5cba2a452e969',
                        'min' => 1,
                        'max' => 0,
                        'layout' => 'table',
                        'button_label' => '',
                        'sub_fields' => array(
                            array(
                                'key' => 'field_5cba2a452e969',
                                'label' => 'Name',
                                'name' => 'name',
                                'type' => 'text',
                                'instructions' => '',
                                'required' => 1,
                                'conditional_logic' => 0,
                                'wrapper' => array(
                                    'width' => '',
                                    'class' => '',
                                    'id' => '',
                                ),
                                'default_value' => '',
                                'placeholder' => '',
                                'prepend' => '',
                                'append' => '',
                                'maxlength' => '',
                            ),
                            array(
                                'key' => 'field_5cba2a812e96a',
                                'label' => 'Version',
                                'name' => 'version',
                                'type' => 'text',
                                'instructions' => '',
                                'required' => 0,
                                'conditional_logic' => 0,
                                'wrapper' => array(
                                    'width' => '',
                                    'class' => '',
                                    'id' => '',
                                ),
                                'default_value' => '',
                                'placeholder' => '',
                                'prepend' => '',
                                'append' => '',
                                'maxlength' => '',
                            ),
                            array(
                                'key' => 'field_5cba2a962e96b',
                                'label' => 'Link',
                                'name' => 'link',
                                'type' => 'url',
                                'instructions' => '',
                                'required' => 0,
                                'conditional_logic' => 0,
                                'wrapper' => array(
                                    'width' => '',
                                    'class' => '',
                                    'id' => '',
                                ),
                                'default_value' => '',
                                'placeholder' => '',
                            ),
                        ),
                    ),
                    array(
                        'key' => 'field_5c3a17afac612',
                        'label' => 'Screenshot',
                        'name' => 'screenshot',
                        'type' => 'flexible_content',
                        'instructions' => 'Visuel du projet',
                        'required' => 1,
                        'conditional_logic' => 0,
                        'wrapper' => array(
                            'width' => '',
                            'class' => '',
                            'id' => '',
                        ),
                        'layouts' => array(
                            'layout_5cba2ab74a598' => array(
                                'key' => 'layout_5cba2ab74a598',
                                'name' => 'image',
                                'label' => 'Image',
                                'display' => 'block',
                                'sub_fields' => array(
                                    array(
                                        'key' => 'field_5cba2ae92e96d',
                                        'label' => 'Image',
                                        'name' => 'image',
                                        'type' => 'image',
                                        'instructions' => '',
                                        'required' => 0,
                                        'conditional_logic' => 0,
                                        'wrapper' => array(
                                            'width' => '',
                                            'class' => '',
                                            'id' => '',
                                        ),
                                        'return_format' => 'array',
                                        'preview_size' => 'medium',
                                        'library' => 'all',
                                        'min_width' => '',
                                        'min_height' => '',
                                        'min_size' => '',
                                        'max_width' => '',
                                        'max_height' => '',
                                        'max_size' => '',
                                        'mime_types' => 'png,jpg,jpeg',
                                    ),
                                ),
                                'min' => '',
                                'max' => '',
                            ),
                            'layout_5cba2c9b396ac' => array(
                                'key' => 'layout_5cba2c9b396ac',
                                'name' => 'gallery',
                                'label' => 'Gallery',
                                'display' => 'block',
                                'sub_fields' => array(
                                    array(
                                        'key' => 'field_5cba2cac396ae',
                                        'label' => 'Gallery',
                                        'name' => 'gallery',
                                        'type' => 'gallery',
                                        'instructions' => '',
                                        'required' => 0,
                                        'conditional_logic' => 0,
                                        'wrapper' => array(
                                            'width' => '',
                                            'class' => '',
                                            'id' => '',
                                        ),
                                        'min' => 1,
                                        'max' => '',
                                        'insert' => 'append',
                                        'library' => 'all',
                                        'min_width' => '',
                                        'min_height' => '',
                                        'min_size' => '',
                                        'max_width' => '',
                                        'max_height' => '',
                                        'max_size' => '',
                                        'mime_types' => 'png,jpg,jpeg',
                                    ),
                                ),
                                'min' => '',
                                'max' => '',
                            ),
                        ),
                        'button_label' => 'Ajouter un élément',
                        'min' => 1,
                        'max' => 1,
                    ),
                    array(
                        'key' => 'field_5cba2b7a2e96e',
                        'label' => 'Source',
                        'name' => 'source',
                        'type' => 'flexible_content',
                        'instructions' => 'Rendu du projet',
                        'required' => 1,
                        'conditional_logic' => 0,
                        'wrapper' => array(
                            'width' => '',
                            'class' => '',
                            'id' => '',
                        ),
                        'layouts' => array(
                            'layout_5cba2d02396af' => array(
                                'key' => 'layout_5cba2d02396af',
                                'name' => 'github',
                                'label' => 'Github',
                                'display' => 'block',
                                'sub_fields' => array(
                                    array(
                                        'key' => 'field_5cba2d11396b0',
                                        'label' => 'Url',
                                        'name' => 'url',
                                        'type' => 'url',
                                        'instructions' => '',
                                        'required' => 0,
                                        'conditional_logic' => 0,
                                        'wrapper' => array(
                                            'width' => '',
                                            'class' => '',
                                            'id' => '',
                                        ),
                                        'default_value' => '',
                                        'placeholder' => '',
                                    ),
                                ),
                                'min' => '',
                                'max' => '',
                            ),
                            'layout_5cba2be1c8454' => array(
                                'key' => 'layout_5cba2be1c8454',
                                'name' => 'file',
                                'label' => 'File',
                                'display' => 'block',
                                'sub_fields' => array(
                                    array(
                                        'key' => 'field_5cba2c0a2e970',
                                        'label' => 'File',
                                        'name' => 'file',
                                        'type' => 'file',
                                        'instructions' => '',
                                        'required' => 0,
                                        'conditional_logic' => 0,
                                        'wrapper' => array(
                                            'width' => '',
                                            'class' => '',
                                            'id' => '',
                                        ),
                                        'return_format' => 'array',
                                        'library' => 'all',
                                        'min_size' => '',
                                        'max_size' => '',
                                        'mime_types' => 'zip,tar,gz',
                                    ),
                                ),
                                'min' => '',
                                'max' => '',
                            ),
                            'layout_5cc1ee4fc674c' => array(
                                'key' => 'layout_5cc1ee4fc674c',
                                'name' => 'demo',
                                'label' => 'Demo',
                                'display' => 'block',
                                'sub_fields' => array(
                                    array(
                                        'key' => 'field_5cc1ee56c674d',
                                        'label' => 'Url',
                                        'name' => 'url',
                                        'type' => 'url',
                                        'instructions' => '',
                                        'required' => 0,
                                        'conditional_logic' => 0,
                                        'wrapper' => array(
                                            'width' => '',
                                            'class' => '',
                                            'id' => '',
                                        ),
                                        'default_value' => '',
                                        'placeholder' => '',
                                    ),
                                ),
                                'min' => '',
                                'max' => '',
                            ),
                        ),
                        'button_label' => 'Ajouter un élément',
                        'min' => 1,
                        'max' => 2,
                    ),
                ),
                'location' => array(
                    array(
                        array(
                            'param' => 'post_type',
                            'operator' => '==',
                            'value' => 'project',
                        ),
                    ),
                ),
                'menu_order' => 0,
                'position' => 'acf_after_title',
                'style' => 'default',
                'label_placement' => 'top',
                'instruction_placement' => 'label',
                'hide_on_screen' => '',
                'active' => true,
                'description' => '',
            )
        );
    }
}
add_action( 'acf/init', 'add_project_field_group' );