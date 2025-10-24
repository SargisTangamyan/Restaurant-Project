import { sender } from '@/api/Sender.js' // adjust path if needed
import {
  STRIPE_CANCEL_PAYMENT,
  STRIPE_CREATE_CHECKOUT,
  STRIPE_VERIFY_PAYMENT
} from "@/constants/urls.js";

/**
 * Create a new Stripe checkout session
 */
export const createCheckoutSession = async () => {
  const response = await sender.sendRequest('POST', STRIPE_CREATE_CHECKOUT);
  if (!response.success) throw response.errors;
  return response.data;
};

/**
 * Verify a payment by sessionId and orderId
 * @param {string} sessionId
 * @param {string} orderId
 */
export const verifyPayment = async (sessionId, orderId) => {
  const response = await sender.sendRequest('POST', STRIPE_VERIFY_PAYMENT, {
    session_id: sessionId,
    order_id: orderId
  });
  if (!response.success) throw response.errors;
  return response.data;
};

/**
 * Cancel a payment by orderId
 * @param {string} orderId
 */
export const cancelPayment = async (orderId) => {
  const response = await sender.sendRequest('POST', STRIPE_CANCEL_PAYMENT, {
    order_id: orderId
  });
  if (!response.success) throw response.errors;
  return response.data;
};
