<?php


/**
 * Class MockController
 *
 * Needed for testing if FrontController execute controller methods
 */
class MockController
{
    public function mockTrueMethodAction()
    {
        return true;
    }

    public function mockFalseMethodAction()
    {
        return false;
    }

    public function mockStringReturnAction()
    {
        return 'testing';
    }
}