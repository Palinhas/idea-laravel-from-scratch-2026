<x-layout>
  <x-form title="Log in" description="Welcome back! Please enter your credentials to access your account.">
      <form action="/login" method="post" class="mt-10 space-y-4">
          @csrf

{{--          <x-form.field name="name" label="Name" />--}}
          <x-form.field type="email" name="email" label="Email" />
          <x-form.field type="password" name="password" label="Password" />

          <button type="submit" class="btn mt-2 h-10 w-full">Sign in</button>
      </form>
  </x-form>
</x-layout>


