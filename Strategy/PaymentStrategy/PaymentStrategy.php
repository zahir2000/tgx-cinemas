<?php

/**
 *
 * @author Zahir
 */
interface PaymentStrategy {

    public function pay($amount);
}