<p>
    <label for="<?php echo $this->get_field_id( 'number_posts' ); ?>"><?php _e( 'Quantidade de slides:' ); ?></label> 
    <input
        class="widefat"
        id="<?php echo $this->get_field_id( 'number_posts' ); ?>"
        name="<?php echo $this->get_field_name( 'number_posts' ); ?>"
        type="text"
        value="<?php echo esc_attr( $number_posts ); ?>"
    />
</p>