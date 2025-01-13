$(document).ready(function () {
    console.log(merchant_id)
    let config = {
        gateway: {
            publicKey: tap_pub_key,
            merchantId: merchant_id,
            language: 'en',
            contactInfo: false,
            supportedCurrencies: user_currency,
            supportedPaymentMethods: 'all',
            saveCardOption: true,
            customerCards: true,
            notifications: 'standard',
            callback: (response) => {
                console.log('callback', response)
                if (response && response.status === 'CAPTURED') {
                    window.location.href = APP_URL + '/paymentSuccess?' +
                        'amount=' + amount +
                        '&member_id=' + member_id +
                        '&merchant_id=' + merchant_id +
                        '&currency=' + user_currency +
                        '&user_name=' + name +
                        '&user_email=' + email +
                        '&user_country_code=' + country_code +
                        '&user_mobile_no=' + mobile_number;
                } else if (response && response.status === 'CANCELLED') {
                    window.location.href = APP_URL + '/paymentCancel?' +
                        'amount=' + amount +
                        '&member_id=' + member_id +
                        '&merchant_id=' + merchant_id +
                        '&currency=' + user_currency +
                        '&user_name=' + name +
                        '&user_email=' + email +
                        '&user_country_code=' + country_code +
                        '&user_mobile_no=' + mobile_number;
                } else {
                    window.location.href = APP_URL + '/paymentCancel?' +
                        'amount=' + amount +
                        '&member_id=' + member_id +
                        '&merchant_id=' + merchant_id +
                        '&currency=' + user_currency +
                        '&user_name=' + name +
                        '&user_email=' + email +
                        '&user_country_code=' + country_code +
                        '&user_mobile_no=' + mobile_number;
                }
            },
            onClose: () => {
                window.location.href = APP_URL + '/paymentCancel?amount=' + amount + '&member_id=' + member_id + '&merchant_id=' + merchant_id + '&currency=' + user_currency + '&user_name=' + name + '&user_email=' + email + '&user_country_code=' + country_code + '&user_mobile_no=' + mobile_number
            },
            onLoad: () => {
                console.log('onLoad')
                goSell.openLightBox()
            },
            style: {
                base: {
                    color: 'red',
                    lineHeight: '10px',
                    fontFamily: 'sans-serif',
                    fontSmoothing: 'antialiased',
                    fontSize: '10px',
                    '::placeholder': {
                        color: 'rgba(0, 0, 0, 0.26)',
                        fontSize: '10px',
                    },
                },
                invalid: {
                    color: 'red',
                    iconColor: '#fa755a ',
                },
            },
        },
        TransactionMode:    'TOKENIZE_  CARD',
        customer: {
            first_name: name,
            middle_name: 'test',
            last_name: name,
            email: email,
            phone: {
                country_code: country_code,
                number: mobile_number,
            },
        },
        order: {
            amount: amount,
            currency: user_currency,
        },
        // transaction: {
        //     mode: 'tokenize', // Changed from "charge" to "tokenize"
        // },
        transaction: {
            mode: 'charge',
            charge: {
                auto: {
                    time: 1000,
                    type: 'VOID',
                },
                saveCard: true,
                threeDSecure: true,
                description: 'Payment of topup merchant wallet',
                statement_descriptor: 'statement_descriptor',
                reference: {
                    transaction: transaction_id,
                    order: transaction_id,
                }, metadata: {
                    user_amount: user_amount,
                    user_currency: user_currency,
                },
                receipt: {
                    email: false,
                    sms: false,
                },
                redirect: APP_URL + '/paymentSuccess?amount=' + amount + '&member_id=' + member_id + '&merchant_id=' + merchant_id + '&currency=' + user_currency + '&user_name=' + name + '&user_email=' + email + '&user_country_code=' + country_code + '&user_mobile_no=' + mobile_number,
                post: null,
            },
        },
    }
    console.log(config)
    goSell.config(config)
    // goSell.openLightBox();
})
