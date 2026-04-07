<?php include(RNB_PACKAGE_TEMPLATE_PATH.'rnb/emails/email-header.php'); ?>
  <?php 
  extract($quote);
  // guest checkout handel 
  $guest_checkout_is_enable = get_option('woocommerce_enable_guest_checkout', 'no');
  $book_url = $customer_view_quote;
  $button_text = esc_html__('View Quote & Book Now', 'redq-rental');
  if( $guest_checkout_is_enable == 'yes'){
    $guest_page_url_id = REDQ_RnB\RequestForQuote::get_guest_checkout_id();
    $args = [
      'quote_id' => $id,
      'product_id' => $product_id,
      'rfq_checkout' => 1
    ];
    $book_url  = esc_url( add_query_arg( $args, get_permalink( $guest_page_url_id ) ) );
    $button_text = esc_html__('Book Now', 'redq-rental');
  }
  ?>
  <table width="100%" cellpadding="0" cellspacing="0">
    <tr>
      <td align="center" valign="top">
        <center>

          <table width="100%" style="background:#F7F7F7;border-bottom:1px solid #E5E5E5;">
            <tr>
              <td align="center">
                <center style="padding:0 0 50px 0;">

                  <table width="70%" style="margin:0 auto;">
                    <tr>
                      <td>

                        <table>
                          <tr>
                            <td>
                              <h2 align="left" style="font-family:Georgia,Cambria,'Times New Roman',serif;font-size:32px;font-weight:300;line-height: normal;padding: 35px 0 0;color: #4d4d4d;"><?php echo esc_attr( $heading ) ?></h2>
                            </td>
                          </tr>
                          <tr>
                            <td align="left" style="color:#777777;font-size:14px;line-height:21px;font-weight:400;">
                              <p><?php _e( "Hello, your quote request has been accepted.You can now book as the listed price.", 'redq-rental' ); ?></p>

                              <p><?php _e( "You can now click the book now button in the view quote page. Then checkout the product.", 'redq-rental' ); ?></p>
                            </td>
                          </tr>
                          <tr>
                            <td style="text-align:center;padding:30px 0 15px;">
                              <a href="<?php echo esc_url( $book_url ) ?>" style="background-color:#E74C3C;border-radius:0;color:#ffffff;display:inline-block;font-size:14px;font-weight:normal;line-height:40px;text-align:center;text-decoration:none;width:300px;-webkit-text-size-adjust:none;mso-hide:all;text-transform:uppercase"><?php echo esc_html($button_text); ?></a></div>
                            </td>
                          </tr>
                        </table>

                      </td>
                    </tr>
                  </table>

                </center>
              </td>
            </tr>
          </table>

        </center>
      </td>
    </tr>
  </table>
  
  <?php do_action( 'request_quote_item_details_template', $quote_id ); ?>
  
<?php include(RNB_PACKAGE_TEMPLATE_PATH.'rnb/emails/email-footer.php'); ?>