<?php
namespace Carawebs\Settings;

abstract class Fields

{

    public function fieldCallbackText( array $args ) {
        $fieldArgs = $this->createFieldArgs($args);
        printf( '<input name="%1$s" id="%2$s" type="%3$s" placeholder="%4$s" value="%5$s" />',
            $fieldArgs['name'],
            $fieldArgs['id'],
            $fieldArgs['type'],
            $fieldArgs['placeholder'],
            $fieldArgs['value']
        );
        echo ! empty( $args['desc'] ) ? "<p class='description'>{$args['desc']}</p>" : NULL;
    }

    public function fieldCallbackTextarea( array $args ) {
        $fieldArgs = $this->createFieldArgs($args);
        printf( '<textarea name="%1$s" id="%2$s" type="%3$s" placeholder="%4$s">%5$s</textarea>',
            $fieldArgs['name'],
            $fieldArgs['id'],
            $fieldArgs['type'],
            $fieldArgs['placeholder'],
            $fieldArgs['value']
        );
        echo ! empty( $args['desc'] ) ? "<p class='description'>{$args['desc']}</p>" : NULL;
    }

    public function fieldCallbackSelect(array $args)
    {
        $fieldArgs = $this->createFieldArgs($args);
        $default = 'one';
        ob_start();
        ?>
        <select name=<?= $fieldArgs['name']; ?> id=<?= $fieldArgs['name']; ?>>
            <?php
            foreach ( $fieldArgs['multi_options'] as $text => $value ) {
                ?>
                <option <?php selected( $fieldArgs['value'], $value, true ); ?> value="<?= $value; ?>"><?= $text; ?></option>
                <?php
            }
            ?>
        </select>
        <?php
        echo ! empty( $args['desc'] ) ? "<p class='description'>{$args['desc']}</p>" : NULL;
        echo ob_get_clean();
    }

    /**
     * Create the specific arguments necessary to populate the field callback.
     *
     * @param array $args 'Raw' field arguments
     */
    public function createFieldArgs(array $args)
    {
        $settings = (array)get_option( $args['option'] );
        $option = $args['option'];
        $name = $option . '[' . $args['name'] . ']';
        $id = $args['name'];
        $type = $args['type'];
        $placeholder = $args['placeholder'];
        $multi_options = $args['multi_options'] ?? NULL;
        $value = $settings[$args['name']] ?? NULL;
        $value = esc_attr($value);
        return compact('name', 'id', 'type', 'placeholder', 'value', 'multi_options');
    }


}
