<?php namespace app\common\interfaces;

interface UserInterface
{
    /**
     * @param bool $newToken
     * @param int|null $ttl
     * @return string
     */
    public function resetPassword(bool $newToken = true, int $ttl = null): string;

    /**
     * @param string $email
     * @param bool $newToken
     * @param int|null $ttl
     * @return string
     */
    public function changeLogin(string $email, bool $newToken = true, int $ttl = null): string;
}
