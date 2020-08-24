<?php

/**
 * @author Zahiriddin Rustamov
 */
interface PaymentStrategy {

    public function pay($userId);
}
