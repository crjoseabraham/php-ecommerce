<?php
namespace App\Controller\Helper;

class Flash {
    /**
     * Add a message
     *
     * @param string $message   The message content
     * @param string $type      The optional message type, SUCCESS is default
     *
     * @return void
     */
    public static function addMessage($message, $type = SUCCESS)
    {
        // Create array in the session if it doesn't already exist
        if (! isset($_SESSION['notification'])) {
            $_SESSION['notification'] = [];
        }

        // Append the message to the array
        $_SESSION['notification'][] = [
            'body' => $message,
            'type' => $type
        ];
    }

    /**
     * Get all the messages
     *
     * @return mixed  An array with all the messages or null if none set
     */
    public static function getMessages()
    {
        if (isset($_SESSION['notification'])) {
            $messages = $_SESSION['notification'];
            unset($_SESSION['notification']);

            return $messages;
        }
    }
}