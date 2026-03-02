@props(['name', 'message'])
@error($name)
<p class="error">{{ $message }}</p>
@enderror<?php
