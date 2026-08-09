<x-layouts.admin>
    <x-slot name="title">
        {{ trans_choice('general.updates', 2) }}
    </x-slot>

    <x-slot name="buttons">
        <x-link href="{{ route('updates.check') }}">
            {{ trans('updates.check') }}
        </x-link>
    </x-slot>

    <x-slot name="content">
        <x-update-alert />

        <div class="my-10">
            <div class="flex items-center">
                <div class="relative px-4 text-sm text-center pb-2 text-purple font-medium border-purple transition-all after:absolute after:w-full after:h-0.5 after:left-0 after:right-0 after:bottom-0 after:bg-purple after:rounded-tl-md after:rounded-tr-md">
                    <span>NuvisAccounting</span>
                </div>
            </div>

            <x-table>
                <x-table.tbody>
                    <x-table.tr>
                        @if (empty($core))
                            <x-table.td class="w-12/12" kind="cursor-none">
                                {{ trans('updates.latest_core') }}
                            </x-table.td>
                        @else
                            <x-table.td class="w-6/12" kind="cursor-none">
                                {{ trans('updates.new_core') }}
                            </x-table.td>

                            <x-table.td kind="right" class="w-6/12" kind="cursor-none">
                                <x-slot name="first" class="flex justify-end" override="class">
                                    @if (! $core->errors)
                                        <x-link href="{{ route('updates.run', ['alias' => 'core', 'version' => $core->latest]) }}" class="px-3 py-1.5 rounded-xl text-sm font-medium leading-6 ltr:mr-2 rtl:ml-2 bg-green text-white hover:bg-green-700 disabled:bg-green-100" override="class">
                                            {{ trans('updates.update', ['version' => $core->latest]) }}
                                        </x-link>
                                    @else
                                        <x-tooltip id="tooltip-core-button" placement="top" :message="$core->message">
                                            <x-button class="px-3 py-1.5 rounded-xl text-sm font-medium leading-6 ltr:mr-2 rtl:ml-2 text-white bg-green-300 cursor-default" override="class">
                                                {{ trans('updates.update', ['version' => $core->latest]) }}
                                            </x-button>
                                        </x-tooltip>
                                    @endif

                                    <x-button @click="onChangelog">
                                        {{ trans('updates.changelog') }}
                                    </x-button>
                                </x-slot>
                            </x-table.td>
                        @endif
                    </x-table.tr>
                </x-table.tbody>
            </x-table>
        </div>

        <div class="my-10 bg-white p-6 rounded-xl border border-gray-200">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-medium text-gray-900">Direct Repository Update (Git Pull)</h3>
                <div class="flex space-x-2">
                    <button id="btn-repo-pull" class="px-4 py-2 bg-purple text-white rounded-xl hover:bg-purple-700 disabled:bg-purple-300 flex items-center" onclick="triggerRepoPull()">
                        <span id="btn-repo-pull-text" class="flex items-center">
                            <i class="fa fa-git mr-2"></i> Pull & Update System
                        </span>
                    </button>
                    <button id="btn-repo-logs" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-xl hover:bg-gray-300 flex items-center" onclick="fetchRepoLogs()">
                        Refresh Logs
                    </button>
                    <button id="btn-repo-clear" class="px-4 py-2 bg-red-100 text-red-700 rounded-xl hover:bg-red-200 flex items-center" onclick="clearRepoLogs()">
                        Clear Logs
                    </button>
                </div>
            </div>
            <p class="text-sm text-gray-500 mb-4">
                Pushing the button below will pull the latest updates directly from your configured Git repository on branch <strong>main</strong>, clear system caches, and run any database migrations.
            </p>

            <div class="bg-black text-green-400 p-4 rounded-xl font-mono text-xs overflow-y-auto max-h-96" style="background-color: #1e1e1e; color: #39ff14; min-height: 200px;">
                <pre id="repo-log-display" class="whitespace-pre-wrap">No log history found. Click "Pull & Update System" to begin.</pre>
            </div>
        </div>

        <script>
            function fetchRepoLogs() {
                const display = document.getElementById('repo-log-display');
                axios.get(url + '/install/updates/repo-logs')
                    .then(response => {
                        if (response.data && response.data.success) {
                            display.textContent = response.data.logs || 'No log history found.';
                        }
                    })
                    .catch(error => {
                        console.error('Error fetching repo logs:', error);
                    });
            }

            function clearRepoLogs() {
                if (confirm('Are you sure you want to clear the repository update logs?')) {
                    const display = document.getElementById('repo-log-display');
                    axios.post(url + '/install/updates/repo-clear-logs')
                        .then(response => {
                            if (response.data && response.data.success) {
                                display.textContent = 'Logs cleared.';
                            }
                        })
                        .catch(error => {
                            console.error('Error clearing repo logs:', error);
                        });
                }
            }

            function triggerRepoPull() {
                const btn = document.getElementById('btn-repo-pull');
                const btnText = document.getElementById('btn-repo-pull-text');
                const display = document.getElementById('repo-log-display');

                if (confirm('Are you sure you want to run the pull and update commands now?')) {
                    btn.disabled = true;
                    btnText.innerHTML = '<i class="fa fa-spinner fa-spin mr-2"></i> Updating...';
                    display.textContent = '--- Pull process initiated. Waiting for command outputs... ---';

                    // Start polling the logs while the action executes
                    const logInterval = setInterval(fetchRepoLogs, 1500);

                    axios.post(url + '/install/updates/repo-pull')
                        .then(response => {
                            clearInterval(logInterval);
                            fetchRepoLogs();
                            btn.disabled = false;
                            btnText.innerHTML = '<i class="fa fa-git mr-2"></i> Pull & Update System';

                            if (response.data && response.data.success) {
                                alert('System updated successfully from repository.');
                            } else {
                                alert('Update complete with warning or errors. Please check the terminal logs.');
                            }
                        })
                        .catch(error => {
                            clearInterval(logInterval);
                            fetchRepoLogs();
                            btn.disabled = false;
                            btnText.innerHTML = '<i class="fa fa-git mr-2"></i> Pull & Update System';
                            alert('Repository update failed. Please check the logs.');
                        });
                }
            }

            // Fetch logs automatically when the page loads
            document.addEventListener('DOMContentLoaded', function() {
                setTimeout(fetchRepoLogs, 1000);
            });
        </script>

        <div class="flex items-center">
            <div class="relative px-4 text-sm text-center pb-2 text-purple font-medium border-purple transition-all after:absolute after:w-full after:h-0.5 after:left-0 after:right-0 after:bottom-0 after:bg-purple after:rounded-tl-md after:rounded-tr-md">
                {{ trans_choice('general.modules', 2) }}
            </div>
        </div>

        <x-index.container class="my-0" override="class">
            <x-table>
                <x-table.thead>
                    <x-table.tr>
                        <x-table.th class="w-3/12">
                            {{ trans('general.name') }}
                        </x-table.th>

                        <x-table.th class="w-3/12" hidden-mobile>
                            {{ trans('updates.installed_version') }}
                        </x-table.th>

                        <x-table.th class="w-3/12" hidden-mobile>
                            {{ trans('updates.latest_version') }}
                        </x-table.th>

                        <x-table.th class="w-3/12" kind="right">
                            {{ trans('general.actions') }}
                        </x-table.th>
                    </x-table.tr>
                </x-table.thead>

                <x-table.tbody>
                    @if ($modules)
                        @foreach ($modules as $module)
                        <x-table.tr>
                            <x-table.td class="w-3/12" kind="cursor-none">
                                {{ $module->name }}
                            </x-table.td>

                            <x-table.td class="w-3/12" kind="cursor-none">
                                {{ $module->installed }}
                            </x-table.td>

                            <x-table.td class="w-3/12" kind="cursor-none">
                                {{ $module->latest }}
                            </x-table.td>

                            <x-table.td class="w-3/12" kind="right">
                                @if (empty($module->errors))
                                    <x-link href="{{ route('updates.run', ['alias' => $module->alias, 'version' => $module->latest]) }}" kind="primary">
                                        {{ trans_choice('general.updates', 1) }}
                                    </x-link>
                                @else
                                    <x-tooltip id="tooltip-modules-{{ $module->alias }}" placement="top" :message="$module->message">
                                        <x-button class="px-3 py-1.5 rounded-xl text-sm font-medium leading-6 text-white bg-green-300 cursor-default" override="class">
                                            {{ trans_choice('general.updates', 1) }}
                                        </x-button>
                                    </x-tooltip>
                                @endif
                            </x-table.td>
                        </x-table.tr>
                        @endforeach
                    @else
                        <x-table.tr>
                            <x-table.td class="w-4/12">
                                <small>{{ trans('general.no_records') }}</small>
                            </x-table.td>
                        </x-table.tr>
                    @endif
                </x-table.tbody>
            </x-table>
        </x-index.container>

        <nuvisaccounting-modal v-if="changelog.show"
            modal-dialog-class="max-w-screen-xl change-log-modal"
            :show="changelog.show"
            :title="'{{ trans('updates.changelog') }}'"
            @cancel="changelog.show = false"
            :message="changelog.html">
            <template #card-footer>
                <span></span>
            </template>
        </nuvisaccounting-modal>
    </x-slot>

    <x-script folder="install" file="update" />
</x-layouts.admin>
