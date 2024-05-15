<x-mails::layout>
    <table class="bg-base-100 rounded-t-lg p-10 block">
        <tr>
            <td>
                <h2 class="pb-4 font-bold text-[#13525F]">Ciao {{$username}}!</h2>
                <p>Please click the button below to verify your email address.</p>
            </td>
        </tr>
        <tr>
            <td class="py-4 w-full flex items-center justify-center">
                <a class="btn bg-[#00AACC] text-base-100 rounded-lg border-0" href="{{$url}}">Verifica la tua email</a>
            </td>
        </tr>
        <tr>
            <td>
                <p class="pb-4">If you did not create an account, no further action is required.</p>
                <p>Regards,</p>
                <p>Fantapronostico</p>
            </td>
        </tr>
        <tr>
            <td>
                <div class="divider"></div>
            </td>
        </tr>
        <tr>
            <td>
                <p class="text-sm">
                    If you're having trouble clicking the "Verify Email Address" button, copy and paste the URL below into your web browser:
                    <a href="{{$url}}" class="break-all link text-blue-600 visited:text-purple-600">
                        {{$url}}
                    </a>
                </p>
            </td>
        </tr>
    </table>
</x-mails::layout>
