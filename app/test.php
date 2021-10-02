<?php
[2020-12-11 10:16:20] local.DEBUG: array (
    0 => 'whsec_iJwXTHfymEcTWuHuCErRfyXXLrP0OIj9

',
    1 => 'sk_test_cCunDXXVEd3ZuUzzna70pf0u',
    2 => '{
  "id": "evt_1Hx7kaK0QtLUSPguO20JKJfe",
  "object": "event",
  "api_version": "2020-08-27",
  "created": 1607678240,
  "data": {
    "object": {
      "id": "in_1Hx7kKK0QtLUSPguZviNUomq",
      "object": "invoice",
      "account_country": "US",
      "account_name": "Froiden-Shrikant",
      "account_tax_ids": null,
      "amount_due": 50000,
      "amount_paid": 50000,
      "amount_remaining": 0,
      "application_fee_amount": null,
      "attempt_count": 1,
      "attempted": true,
      "auto_advance": false,
      "billing_reason": "subscription_create",
      "charge": "ch_1Hx7kZK0QtLUSPguicSQ7ZNE",
      "collection_method": "charge_automatically",
      "created": 1607678224,
      "currency": "usd",
      "custom_fields": null,
      "customer": "cus_IYBLrhE0su98lO",
      "customer_address": null,
      "customer_email": "admin@example.com",
      "customer_name": null,
      "customer_phone": null,
      "customer_shipping": null,
      "customer_tax_exempt": "none",
      "customer_tax_ids": [

      ],
      "default_payment_method": null,
      "default_source": null,
      "default_tax_rates": [

      ],
      "description": null,
      "discount": null,
      "discounts": [

      ],
      "due_date": null,
      "ending_balance": 0,
      "footer": null,
      "hosted_invoice_url": "https://invoice.stripe.com/i/acct_1Bkc04K0QtLUSPgu/invst_IYECob1MLuCbQFiHQ7ueaNkrzFsCVwl",
      "invoice_pdf": "https://pay.stripe.com/invoice/acct_1Bkc04K0QtLUSPgu/invst_IYECob1MLuCbQFiHQ7ueaNkrzFsCVwl/pdf",
      "last_finalization_error": null,
      "lines": {
        "object": "list",
        "data": [
          {
            "id": "il_1Hx7kKK0QtLUSPguRWTb0qhL",
            "object": "line_item",
            "amount": 50000,
            "currency": "usd",
            "description": "1 × Monthly (at $500.00 / month)",
            "discount_amounts": [

            ],
            "discountable": true,
            "discounts": [

            ],
            "livemode": false,
            "metadata": {
            },
            "period": {
              "end": 1610356624,
              "start": 1607678224
            },
            "plan": {
              "id": "larger_monthly",
              "object": "plan",
              "active": true,
              "aggregate_usage": null,
              "amount": 50000,
              "amount_decimal": "50000",
              "billing_scheme": "per_unit",
              "created": 1554096943,
              "currency": "usd",
              "interval": "month",
              "interval_count": 1,
              "livemode": false,
              "metadata": {
              },
              "nickname": "larger monthly",
              "product": "prod_EnucAo9PZccsQr",
              "tiers_mode": null,
              "transform_usage": null,
              "trial_period_days": null,
              "usage_type": "licensed"
            },
            "price": {
              "id": "larger_monthly",
              "object": "price",
              "active": true,
              "billing_scheme": "per_unit",
              "created": 1554096943,
              "currency": "usd",
              "livemode": false,
              "lookup_key": null,
              "metadata": {
              },
              "nickname": "larger monthly",
              "product": "prod_EnucAo9PZccsQr",
              "recurring": {
                "aggregate_usage": null,
                "interval": "month",
                "interval_count": 1,
                "trial_period_days": null,
                "usage_type": "licensed"
              },
              "tiers_mode": null,
              "transform_quantity": null,
              "type": "recurring",
              "unit_amount": 50000,
              "unit_amount_decimal": "50000"
            },
            "proration": false,
            "quantity": 1,
            "subscription": "sub_IYECJHHoIBx0Ye",
            "subscription_item": "si_IYECexQRZepquC",
            "tax_amounts": [

            ],
            "tax_rates": [

            ],
            "type": "subscription"
          }
        ],
        "has_more": false,
        "total_count": 1,
        "url": "/v1/invoices/in_1Hx7kKK0QtLUSPguZviNUomq/lines"
      },
      "livemode": false,
      "metadata": {
      },
      "next_payment_attempt": null,
      "number": "60057F7C-0002",
      "paid": true,
      "payment_intent": "pi_1Hx7kKK0QtLUSPgupZ9ygtYz",
      "period_end": 1607678224,
      "period_start": 1607678224,
      "post_payment_credit_notes_amount": 0,
      "pre_payment_credit_notes_amount": 0,
      "receipt_number": null,
      "starting_balance": 0,
      "statement_descriptor": null,
      "status": "paid",
      "status_transitions": {
        "finalized_at": 1607678224,
        "marked_uncollectible_at": null,
        "paid_at": 1607678240,
        "voided_at": null
      },
      "subscription": "sub_IYECJHHoIBx0Ye",
      "subtotal": 50000,
      "tax": null,
      "total": 50000,
      "total_discount_amounts": [

      ],
      "total_tax_amounts": [

      ],
      "transfer_data": null,
      "webhooks_delivered_at": 1607678224
    }
  },
  "livemode": false,
  "pending_webhooks": 1,
  "request": {
    "id": null,
    "idempotency_key": "pi_1Hx7kKK0QtLUSPgupZ9ygtYz-src_1Hx7kLK0QtLUSPguwlhqA0yu"
  },
  "type": "invoice.payment_succeeded"
}',
    3 => 't=1607681779,v1=057f1533ade9b83668712278015cc1fa36cbc18add29b1d273377ea7a8cbfca0,v0=c38e793850f9936eac3a51e753ab9c7797e60681b8d562f38b57ffe77a950649',
)
[2020-12-11 10:16:38] local.DEBUG: array (
    0 => 'whsec_iJwXTHfymEcTWuHuCErRfyXXLrP0OIj9

',
    1 => 'sk_test_cCunDXXVEd3ZuUzzna70pf0u',
    2 => '{
  "id": "evt_1Hx7kaK0QtLUSPguXAu42CQA",
  "object": "event",
  "api_version": "2020-08-27",
  "created": 1607678240,
  "data": {
    "object": {
      "id": "pi_1Hx7kKK0QtLUSPgupZ9ygtYz",
      "object": "payment_intent",
      "amount": 50000,
      "amount_capturable": 0,
      "amount_received": 50000,
      "application": null,
      "application_fee_amount": null,
      "canceled_at": null,
      "cancellation_reason": null,
      "capture_method": "automatic",
      "charges": {
        "object": "list",
        "data": [
          {
            "id": "ch_1Hx7kZK0QtLUSPguicSQ7ZNE",
            "object": "charge",
            "amount": 50000,
            "amount_captured": 50000,
            "amount_refunded": 0,
            "application": null,
            "application_fee": null,
            "application_fee_amount": null,
            "balance_transaction": "txn_1Hx7kZK0QtLUSPguPcWfRqaQ",
            "billing_details": {
              "address": {
                "city": "Iure aut atque quia ",
                "country": "US",
                "line1": "Aliquip dolor qui mo",
                "line2": null,
                "postal_code": "45678",
                "state": "Dolore autem minim t"
              },
              "email": null,
              "name": "New Charity Perez",
              "phone": null
            },
            "calculated_statement_descriptor": "Stripe",
            "captured": true,
            "created": 1607678239,
            "currency": "usd",
            "customer": "cus_IYBLrhE0su98lO",
            "description": "Subscription creation",
            "destination": null,
            "dispute": null,
            "disputed": false,
            "failure_code": null,
            "failure_message": null,
            "fraud_details": {
            },
            "invoice": "in_1Hx7kKK0QtLUSPguZviNUomq",
            "livemode": false,
            "metadata": {
            },
            "on_behalf_of": null,
            "order": null,
            "outcome": {
              "network_status": "approved_by_network",
              "reason": null,
              "risk_level": "normal",
              "risk_score": 48,
              "seller_message": "Payment complete.",
              "type": "authorized"
            },
            "paid": true,
            "payment_intent": "pi_1Hx7kKK0QtLUSPgupZ9ygtYz",
            "payment_method": "pm_1Hx7k8K0QtLUSPguIRW3tGjR",
            "payment_method_details": {
              "card": {
                "brand": "visa",
                "checks": {
                  "address_line1_check": "pass",
                  "address_postal_code_check": "pass",
                  "cvc_check": "pass"
                },
                "country": "DE",
                "exp_month": 2,
                "exp_year": 2025,
                "fingerprint": "El6WuW4IrOpSptZJ",
                "funding": "credit",
                "installments": null,
                "last4": "3184",
                "network": "visa",
                "three_d_secure": {
                  "authentication_flow": "challenge",
                  "result": "authenticated",
                  "result_reason": null,
                  "version": "1.0.2"
                },
                "wallet": null
              },
              "type": "card"
            },
            "receipt_email": null,
            "receipt_number": null,
            "receipt_url": "https://pay.stripe.com/receipts/acct_1Bkc04K0QtLUSPgu/ch_1Hx7kZK0QtLUSPguicSQ7ZNE/rcpt_IYECYorBta9wQ9fgJM4cdp3SE4688f4",
            "refunded": false,
            "refunds": {
              "object": "list",
              "data": [

              ],
              "has_more": false,
              "total_count": 0,
              "url": "/v1/charges/ch_1Hx7kZK0QtLUSPguicSQ7ZNE/refunds"
            },
            "review": null,
            "shipping": null,
            "source": null,
            "source_transfer": null,
            "statement_descriptor": null,
            "statement_descriptor_suffix": null,
            "status": "succeeded",
            "transfer_data": null,
            "transfer_group": null
          }
        ],
        "has_more": true,
        "total_count": 2,
        "url": "/v1/charges?payment_intent=pi_1Hx7kKK0QtLUSPgupZ9ygtYz"
      },
      "client_secret": "pi_1Hx7kKK0QtLUSPgupZ9ygtYz_secret_9FWwP1NIoNiI683mGglI7EJYE",
      "confirmation_method": "automatic",
      "created": 1607678224,
      "currency": "usd",
      "customer": "cus_IYBLrhE0su98lO",
      "description": "Subscription creation",
      "invoice": "in_1Hx7kKK0QtLUSPguZviNUomq",
      "last_payment_error": null,
      "livemode": false,
      "metadata": {
      },
      "next_action": null,
      "on_behalf_of": null,
      "payment_method": "pm_1Hx7k8K0QtLUSPguIRW3tGjR",
      "payment_method_options": {
        "card": {
          "installments": null,
          "network": null,
          "request_three_d_secure": "automatic"
        }
      },
      "payment_method_types": [
        "card"
      ],
      "receipt_email": null,
      "review": null,
      "setup_future_usage": "off_session",
      "shipping": null,
      "source": null,
      "statement_descriptor": null,
      "statement_descriptor_suffix": null,
      "status": "succeeded",
      "transfer_data": null,
      "transfer_group": null
    }
  },
  "livemode": false,
  "pending_webhooks": 1,
  "request": {
    "id": null,
    "idempotency_key": "pi_1Hx7kKK0QtLUSPgupZ9ygtYz-src_1Hx7kLK0QtLUSPguwlhqA0yu"
  },
  "type": "payment_intent.succeeded"
}',
    3 => 't=1607681798,v1=acb1f158c7c3313442da01e1f58e4cad26901ef5fb0c7fe8aa6ff7768829996e,v0=4984e99e334cced252e1d48f35964618cc592103b0363e956f8074d3d7f6981e',
)
[2020-12-11 10:16:52] local.DEBUG: array (
    0 => 'whsec_iJwXTHfymEcTWuHuCErRfyXXLrP0OIj9

',
    1 => 'sk_test_cCunDXXVEd3ZuUzzna70pf0u',
    2 => '{
  "id": "evt_1Hx7kMK0QtLUSPgu4TgWHTmM",
  "object": "event",
  "api_version": "2020-08-27",
  "created": 1607678226,
  "data": {
    "object": {
      "id": "in_1Hx7kKK0QtLUSPguZviNUomq",
      "object": "invoice",
      "account_country": "US",
      "account_name": "Froiden-Shrikant",
      "account_tax_ids": null,
      "amount_due": 50000,
      "amount_paid": 0,
      "amount_remaining": 50000,
      "application_fee_amount": null,
      "attempt_count": 1,
      "attempted": true,
      "auto_advance": true,
      "billing_reason": "subscription_create",
      "charge": "ch_1Hx7kLK0QtLUSPguOoXObH9p",
      "collection_method": "charge_automatically",
      "created": 1607678224,
      "currency": "usd",
      "custom_fields": null,
      "customer": "cus_IYBLrhE0su98lO",
      "customer_address": null,
      "customer_email": "admin@example.com",
      "customer_name": null,
      "customer_phone": null,
      "customer_shipping": null,
      "customer_tax_exempt": "none",
      "customer_tax_ids": [

      ],
      "default_payment_method": null,
      "default_source": null,
      "default_tax_rates": [

      ],
      "description": null,
      "discount": null,
      "discounts": [

      ],
      "due_date": null,
      "ending_balance": 0,
      "footer": null,
      "hosted_invoice_url": "https://invoice.stripe.com/i/acct_1Bkc04K0QtLUSPgu/invst_IYECob1MLuCbQFiHQ7ueaNkrzFsCVwl",
      "invoice_pdf": "https://pay.stripe.com/invoice/acct_1Bkc04K0QtLUSPgu/invst_IYECob1MLuCbQFiHQ7ueaNkrzFsCVwl/pdf",
      "last_finalization_error": null,
      "lines": {
        "object": "list",
        "data": [
          {
            "id": "il_1Hx7kKK0QtLUSPguRWTb0qhL",
            "object": "line_item",
            "amount": 50000,
            "currency": "usd",
            "description": "1 × Monthly (at $500.00 / month)",
            "discount_amounts": [

            ],
            "discountable": true,
            "discounts": [

            ],
            "livemode": false,
            "metadata": {
            },
            "period": {
              "end": 1610356624,
              "start": 1607678224
            },
            "plan": {
              "id": "larger_monthly",
              "object": "plan",
              "active": true,
              "aggregate_usage": null,
              "amount": 50000,
              "amount_decimal": "50000",
              "billing_scheme": "per_unit",
              "created": 1554096943,
              "currency": "usd",
              "interval": "month",
              "interval_count": 1,
              "livemode": false,
              "metadata": {
              },
              "nickname": "larger monthly",
              "product": "prod_EnucAo9PZccsQr",
              "tiers_mode": null,
              "transform_usage": null,
              "trial_period_days": null,
              "usage_type": "licensed"
            },
            "price": {
              "id": "larger_monthly",
              "object": "price",
              "active": true,
              "billing_scheme": "per_unit",
              "created": 1554096943,
              "currency": "usd",
              "livemode": false,
              "lookup_key": null,
              "metadata": {
              },
              "nickname": "larger monthly",
              "product": "prod_EnucAo9PZccsQr",
              "recurring": {
                "aggregate_usage": null,
                "interval": "month",
                "interval_count": 1,
                "trial_period_days": null,
                "usage_type": "licensed"
              },
              "tiers_mode": null,
              "transform_quantity": null,
              "type": "recurring",
              "unit_amount": 50000,
              "unit_amount_decimal": "50000"
            },
            "proration": false,
            "quantity": 1,
            "subscription": "sub_IYECJHHoIBx0Ye",
            "subscription_item": "si_IYECexQRZepquC",
            "tax_amounts": [

            ],
            "tax_rates": [

            ],
            "type": "subscription"
          }
        ],
        "has_more": false,
        "total_count": 1,
        "url": "/v1/invoices/in_1Hx7kKK0QtLUSPguZviNUomq/lines"
      },
      "livemode": false,
      "metadata": {
      },
      "next_payment_attempt": null,
      "number": null,
      "paid": false,
      "payment_intent": "pi_1Hx7kKK0QtLUSPgupZ9ygtYz",
      "period_end": 1607678224,
      "period_start": 1607678224,
      "post_payment_credit_notes_amount": 0,
      "pre_payment_credit_notes_amount": 0,
      "receipt_number": null,
      "starting_balance": 0,
      "statement_descriptor": null,
      "status": "open",
      "status_transitions": {
        "finalized_at": 1607678224,
        "marked_uncollectible_at": null,
        "paid_at": null,
        "voided_at": null
      },
      "subscription": "sub_IYECJHHoIBx0Ye",
      "subtotal": 50000,
      "tax": null,
      "total": 50000,
      "total_discount_amounts": [

      ],
      "total_tax_amounts": [

      ],
      "transfer_data": null,
      "webhooks_delivered_at": null
    }
  },
  "livemode": false,
  "pending_webhooks": 1,
  "request": {
    "id": "req_G1nujbdDeL9FBi",
    "idempotency_key": null
  },
  "type": "invoice.payment_failed"
}',
    3 => 't=1607681811,v1=769dfe2dcb1199ba960091acfa21d6991afcfc6003fb1201c3995c5c8f1b871e,v0=69af02a49f3eafdf9f18a7c45aaa2a9008941edf2d6387f8260c7e09ad87c1df',
)
[2020-12-11 10:18:02] local.DEBUG: array (
    0 => 'whsec_iJwXTHfymEcTWuHuCErRfyXXLrP0OIj9

',
    1 => 'sk_test_cCunDXXVEd3ZuUzzna70pf0u',
    2 => '{
  "id": "evt_1Hx7kMK0QtLUSPgusSJuq5zj",
  "object": "event",
  "api_version": "2020-08-27",
  "created": 1607678224,
  "data": {
    "object": {
      "id": "pi_1Hx7kKK0QtLUSPgupZ9ygtYz",
      "object": "payment_intent",
      "amount": 50000,
      "amount_capturable": 0,
      "amount_received": 0,
      "application": null,
      "application_fee_amount": null,
      "canceled_at": null,
      "cancellation_reason": null,
      "capture_method": "automatic",
      "charges": {
        "object": "list",
        "data": [

        ],
        "has_more": false,
        "total_count": 0,
        "url": "/v1/charges?payment_intent=pi_1Hx7kKK0QtLUSPgupZ9ygtYz"
      },
      "client_secret": "pi_1Hx7kKK0QtLUSPgupZ9ygtYz_secret_9FWwP1NIoNiI683mGglI7EJYE",
      "confirmation_method": "automatic",
      "created": 1607678224,
      "currency": "usd",
      "customer": "cus_IYBLrhE0su98lO",
      "description": "Subscription creation",
      "invoice": "in_1Hx7kKK0QtLUSPguZviNUomq",
      "last_payment_error": null,
      "livemode": false,
      "metadata": {
      },
      "next_action": null,
      "on_behalf_of": null,
      "payment_method": null,
      "payment_method_options": {
        "card": {
          "installments": null,
          "network": null,
          "request_three_d_secure": "automatic"
        }
      },
      "payment_method_types": [
        "card"
      ],
      "receipt_email": null,
      "review": null,
      "setup_future_usage": null,
      "shipping": null,
      "source": null,
      "statement_descriptor": null,
      "statement_descriptor_suffix": null,
      "status": "requires_payment_method",
      "transfer_data": null,
      "transfer_group": null
    }
  },
  "livemode": false,
  "pending_webhooks": 1,
  "request": {
    "id": "req_G1nujbdDeL9FBi",
    "idempotency_key": null
  },
  "type": "payment_intent.created"
}',
    3 => 't=1607681881,v1=275889b0b68b5474cbcd3e78fbdcdd5ca4d7168e8c5667e047d8b02071a7c31a,v0=1d9e2d18273eba796bdeb9732c01477728e016f6ece437d7ecbc77107784b58d',
)
[2020-12-11 10:18:20] local.DEBUG: array (
    0 => 'whsec_iJwXTHfymEcTWuHuCErRfyXXLrP0OIj9',
    1 => 'sk_test_cCunDXXVEd3ZuUzzna70pf0u',
    2 => '{
  "id": "evt_1Hx7kNK0QtLUSPgubSSFn7s1",
  "object": "event",
  "api_version": "2020-08-27",
  "created": 1607678225,
  "data": {
    "object": {
      "id": "pi_1Hx7kKK0QtLUSPgupZ9ygtYz",
      "object": "payment_intent",
      "amount": 50000,
      "amount_capturable": 0,
      "amount_received": 0,
      "application": null,
      "application_fee_amount": null,
      "canceled_at": null,
      "cancellation_reason": null,
      "capture_method": "automatic",
      "charges": {
        "object": "list",
        "data": [
          {
            "id": "ch_1Hx7kLK0QtLUSPguOoXObH9p",
            "object": "charge",
            "amount": 50000,
            "amount_captured": 0,
            "amount_refunded": 0,
            "application": null,
            "application_fee": null,
            "application_fee_amount": null,
            "balance_transaction": null,
            "billing_details": {
              "address": {
                "city": "Iure aut atque quia ",
                "country": "US",
                "line1": "Aliquip dolor qui mo",
                "line2": null,
                "postal_code": "45678",
                "state": "Dolore autem minim t"
              },
              "email": null,
              "name": "New Charity Perez",
              "phone": null
            },
            "calculated_statement_descriptor": "Stripe",
            "captured": false,
            "created": 1607678225,
            "currency": "usd",
            "customer": "cus_IYBLrhE0su98lO",
            "description": "Subscription creation",
            "destination": null,
            "dispute": null,
            "disputed": false,
            "failure_code": "authentication_required",
            "failure_message": "Your card was declined. This transaction requires authentication.",
            "fraud_details": {
            },
            "invoice": "in_1Hx7kKK0QtLUSPguZviNUomq",
            "livemode": false,
            "metadata": {
            },
            "on_behalf_of": null,
            "order": null,
            "outcome": {
              "network_status": "declined_by_network",
              "reason": "authentication_required",
              "risk_level": "normal",
              "risk_score": 63,
              "seller_message": "The bank returned the decline code `authentication_required`.",
              "type": "issuer_declined"
            },
            "paid": false,
            "payment_intent": "pi_1Hx7kKK0QtLUSPgupZ9ygtYz",
            "payment_method": "pm_1Hx7k8K0QtLUSPguIRW3tGjR",
            "payment_method_details": {
              "card": {
                "brand": "visa",
                "checks": {
                  "address_line1_check": "pass",
                  "address_postal_code_check": "pass",
                  "cvc_check": "pass"
                },
                "country": "DE",
                "exp_month": 2,
                "exp_year": 2025,
                "fingerprint": "El6WuW4IrOpSptZJ",
                "funding": "credit",
                "installments": null,
                "last4": "3184",
                "network": "visa",
                "three_d_secure": null,
                "wallet": null
              },
              "type": "card"
            },
            "receipt_email": null,
            "receipt_number": null,
            "receipt_url": null,
            "refunded": false,
            "refunds": {
              "object": "list",
              "data": [

              ],
              "has_more": false,
              "total_count": 0,
              "url": "/v1/charges/ch_1Hx7kLK0QtLUSPguOoXObH9p/refunds"
            },
            "review": null,
            "shipping": null,
            "source": null,
            "source_transfer": null,
            "statement_descriptor": null,
            "statement_descriptor_suffix": null,
            "status": "failed",
            "transfer_data": null,
            "transfer_group": null
          }
        ],
        "has_more": false,
        "total_count": 1,
        "url": "/v1/charges?payment_intent=pi_1Hx7kKK0QtLUSPgupZ9ygtYz"
      },
      "client_secret": "pi_1Hx7kKK0QtLUSPgupZ9ygtYz_secret_9FWwP1NIoNiI683mGglI7EJYE",
      "confirmation_method": "automatic",
      "created": 1607678224,
      "currency": "usd",
      "customer": "cus_IYBLrhE0su98lO",
      "description": "Subscription creation",
      "invoice": "in_1Hx7kKK0QtLUSPguZviNUomq",
      "last_payment_error": {
        "charge": "ch_1Hx7kLK0QtLUSPguOoXObH9p",
        "code": "authentication_required",
        "decline_code": "authentication_required",
        "doc_url": "https://stripe.com/docs/error-codes/authentication-required",
        "message": "Your card was declined. This transaction requires authentication.",
        "payment_method": {
          "id": "pm_1Hx7k8K0QtLUSPguIRW3tGjR",
          "object": "payment_method",
          "billing_details": {
            "address": {
              "city": "Iure aut atque quia ",
              "country": "US",
              "line1": "Aliquip dolor qui mo",
              "line2": null,
              "postal_code": "45678",
              "state": "Dolore autem minim t"
            },
            "email": null,
            "name": "New Charity Perez",
            "phone": null
          },
          "card": {
            "brand": "visa",
            "checks": {
              "address_line1_check": "pass",
              "address_postal_code_check": "pass",
              "cvc_check": "pass"
            },
            "country": "DE",
            "exp_month": 2,
            "exp_year": 2025,
            "fingerprint": "El6WuW4IrOpSptZJ",
            "funding": "credit",
            "generated_from": null,
            "last4": "3184",
            "networks": {
              "available": [
                "visa"
              ],
              "preferred": null
            },
            "three_d_secure_usage": {
              "supported": true
            },
            "wallet": null
          },
          "created": 1607678212,
          "customer": "cus_IYBLrhE0su98lO",
          "livemode": false,
          "metadata": {
          },
          "type": "card"
        },
        "type": "card_error"
      },
      "livemode": false,
      "metadata": {
      },
      "next_action": null,
      "on_behalf_of": null,
      "payment_method": null,
      "payment_method_options": {
        "card": {
          "installments": null,
          "network": null,
          "request_three_d_secure": "automatic"
        }
      },
      "payment_method_types": [
        "card"
      ],
      "receipt_email": null,
      "review": null,
      "setup_future_usage": null,
      "shipping": null,
      "source": null,
      "statement_descriptor": null,
      "statement_descriptor_suffix": null,
      "status": "requires_payment_method",
      "transfer_data": null,
      "transfer_group": null
    }
  },
  "livemode": false,
  "pending_webhooks": 1,
  "request": {
    "id": "req_G1nujbdDeL9FBi",
    "idempotency_key": null
  },
  "type": "payment_intent.payment_failed"
}',
    3 => 't=1607681900,v1=3a087154d11d7c3d5a0f9d7ad8d50f8194dc7c41f67fa30e94e25abb4af7f296,v0=2a8bd377d29fade58516eb33967d6b52adf05505bb754f8e4d3f5438910672ae',
)
array (
    0 => 'whsec_iJwXTHfymEcTWuHuCErRfyXXLrP0OIj9',
    1 => 'sk_test_cCunDXXVEd3ZuUzzna70pf0u',
    2 => '{
  "id": "evt_1Hx7kMK0QtLUSPguz6mFPFGD",
  "object": "event",
  "api_version": "2020-08-27",
  "created": 1607678226,
  "data": {
    "object": {
      "id": "pi_1Hx7kKK0QtLUSPgupZ9ygtYz",
      "object": "payment_intent",
      "amount": 50000,
      "amount_capturable": 0,
      "amount_received": 0,
      "application": null,
      "application_fee_amount": null,
      "canceled_at": null,
      "cancellation_reason": null,
      "capture_method": "automatic",
      "charges": {
        "object": "list",
        "data": [
          {
            "id": "ch_1Hx7kLK0QtLUSPguOoXObH9p",
            "object": "charge",
            "amount": 50000,
            "amount_captured": 0,
            "amount_refunded": 0,
            "application": null,
            "application_fee": null,
            "application_fee_amount": null,
            "balance_transaction": null,
            "billing_details": {
              "address": {
                "city": "Iure aut atque quia ",
                "country": "US",
                "line1": "Aliquip dolor qui mo",
                "line2": null,
                "postal_code": "45678",
                "state": "Dolore autem minim t"
              },
              "email": null,
              "name": "New Charity Perez",
              "phone": null
            },
            "calculated_statement_descriptor": "Stripe",
            "captured": false,
            "created": 1607678225,
            "currency": "usd",
            "customer": "cus_IYBLrhE0su98lO",
            "description": "Subscription creation",
            "destination": null,
            "dispute": null,
            "disputed": false,
            "failure_code": "authentication_required",
            "failure_message": "Your card was declined. This transaction requires authentication.",
            "fraud_details": {
            },
            "invoice": "in_1Hx7kKK0QtLUSPguZviNUomq",
            "livemode": false,
            "metadata": {
            },
            "on_behalf_of": null,
            "order": null,
            "outcome": {
              "network_status": "declined_by_network",
              "reason": "authentication_required",
              "risk_level": "normal",
              "risk_score": 63,
              "seller_message": "The bank returned the decline code `authentication_required`.",
              "type": "issuer_declined"
            },
            "paid": false,
            "payment_intent": "pi_1Hx7kKK0QtLUSPgupZ9ygtYz",
            "payment_method": "pm_1Hx7k8K0QtLUSPguIRW3tGjR",
            "payment_method_details": {
              "card": {
                "brand": "visa",
                "checks": {
                  "address_line1_check": "pass",
                  "address_postal_code_check": "pass",
                  "cvc_check": "pass"
                },
                "country": "DE",
                "exp_month": 2,
                "exp_year": 2025,
                "fingerprint": "El6WuW4IrOpSptZJ",
                "funding": "credit",
                "installments": null,
                "last4": "3184",
                "network": "visa",
                "three_d_secure": null,
                "wallet": null
              },
              "type": "card"
            },
            "receipt_email": null,
            "receipt_number": null,
            "receipt_url": null,
            "refunded": false,
            "refunds": {
              "object": "list",
              "data": [

              ],
              "has_more": false,
              "total_count": 0,
              "url": "/v1/charges/ch_1Hx7kLK0QtLUSPguOoXObH9p/refunds"
            },
            "review": null,
            "shipping": null,
            "source": null,
            "source_transfer": null,
            "statement_descriptor": null,
            "statement_descriptor_suffix": null,
            "status": "failed",
            "transfer_data": null,
            "transfer_group": null
          }
        ],
        "has_more": false,
        "total_count": 1,
        "url": "/v1/charges?payment_intent=pi_1Hx7kKK0QtLUSPgupZ9ygtYz"
      },
      "client_secret": "pi_1Hx7kKK0QtLUSPgupZ9ygtYz_secret_9FWwP1NIoNiI683mGglI7EJYE",
      "confirmation_method": "automatic",
      "created": 1607678224,
      "currency": "usd",
      "customer": "cus_IYBLrhE0su98lO",
      "description": "Subscription creation",
      "invoice": "in_1Hx7kKK0QtLUSPguZviNUomq",
      "last_payment_error": null,
      "livemode": false,
      "metadata": {
      },
      "next_action": {
        "type": "use_stripe_sdk",
        "use_stripe_sdk": {
          "type": "three_d_secure_redirect",
          "stripe_js": "https://hooks.stripe.com/redirect/authenticate/src_1Hx7kLK0QtLUSPguwlhqA0yu?client_secret=src_client_secret_szcnwi7R8cN1d731LClAJ81m",
          "source": "src_1Hx7kLK0QtLUSPguwlhqA0yu"
        }
      },
      "on_behalf_of": null,
      "payment_method": "pm_1Hx7k8K0QtLUSPguIRW3tGjR",
      "payment_method_options": {
        "card": {
          "installments": null,
          "network": null,
          "request_three_d_secure": "automatic"
        }
      },
      "payment_method_types": [
        "card"
      ],
      "receipt_email": null,
      "review": null,
      "setup_future_usage": "off_session",
      "shipping": null,
      "source": null,
      "statement_descriptor": null,
      "statement_descriptor_suffix": null,
      "status": "requires_action",
      "transfer_data": null,
      "transfer_group": null
    }
  },
  "livemode": false,
  "pending_webhooks": 1,
  "request": {
    "id": "req_G1nujbdDeL9FBi",
    "idempotency_key": null
  },
  "type": "payment_intent.requires_action"
}',
    3 => 't=1607681901,v1=ac03c42ee0fea9430a3ba43487d6946a4d470d94b762857ac6e3d03c77221471,v0=dd72fc0a976df6c2d03f6d56b0844addb76567f86909e5682abe937fdf135788',
)
