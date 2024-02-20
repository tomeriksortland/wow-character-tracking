import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import {Head, useForm, usePage} from '@inertiajs/react';
import CharacterCard from "@/Components/CharacterCard";

export default function Index({auth, apierrors, lastSixCharacterSearches}) {
    const {data, setData, post, errors, reset} = useForm({
        region: 'Region',
        realm: '',
        characterName: ''
    })


    const submit = (e) => {
        e.preventDefault();
        post(route('character-search.store'));
    };

    return (
        <AuthenticatedLayout
            user={auth.user}
            header={<h2
                className="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Character search</h2>}>
            <Head title="Character search"/>

            <div className="flex justify-center mt-10 bg-gray-100 dark:bg-gray-900">
                <div
                    className="w-full sm:max-w-xl px-6 py-4 bg-white dark:bg-gray-800 shadow-md overflow-hidden sm:rounded-lg">
                    <form onSubmit={submit}>

                        <div className="flex">
                            <button id="states-button" data-dropdown-toggle="dropdown-states"
                                    className="flex-shrink-0 z-10 inline-flex items-center py-2.5 px-4 text-sm font-medium text-center text-gray-500 bg-gray-100 border border-gray-300 rounded-l-lg hover:bg-gray-200 focus:ring-4 focus:outline-none focus:ring-gray-100 dark:bg-gray-700 dark:hover:bg-gray-600 dark:focus:ring-gray-700 dark:text-white dark:border-gray-600"
                                    type="button">
                                {data.region}
                                <svg aria-hidden="true" className="w-4 h-4 ml-1" fill="currentColor"
                                     viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                    <path fillRule="evenodd"
                                          d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                          clipRule="evenodd"></path>
                                </svg>
                            </button>
                            <div id="dropdown-states"
                                 className="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-44 dark:bg-gray-700">
                                <ul className="py-2 text-sm text-gray-700 dark:text-gray-200"
                                    aria-labelledby="states-button">
                                    <li>
                                        <button type="button"
                                                onClick={() => setData('region', 'EU')}
                                                className="inline-flex w-full px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-600 dark:hover:text-white">
                                            <div className="inline-flex items-center">
                                                EU
                                            </div>
                                        </button>
                                    </li>
                                    <li>
                                        <button type="button"
                                                onClick={() => setData('region', 'US')}
                                                className="inline-flex w-full px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-600 dark:hover:text-white">
                                            <div className="inline-flex items-center">
                                                US
                                            </div>
                                        </button>
                                    </li>
                                </ul>
                            </div>
                            <input id="realm"
                                   name="realm"
                                   onChange={e => setData('realm', e.target.value)}
                                   placeholder="Realm the character is on..."
                                   className="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-r-lg border-l-gray-100 dark:border-l-gray-700 border-l-2 focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"/>
                        </div>

                        <div className="mt-5">
                            <input id="characterName"
                                   name="characterName"
                                   onChange={e => setData('characterName', e.target.value)}
                                   placeholder="Search for character name..."
                                   className="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg border-l-gray-100 dark:border-l-gray-700 border-l-2 focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"/>
                            {apierrors &&
                                <p className="mt-2 text-sm text-red-600 dark:text-red-500"><span
                                    className="font-medium">{apierrors}</span></p>

                            }
                        </div>

                        <div>
                            <button type="submit"
                                    className="w-full text-white bg-gradient-to-br mt-4 from-green-400 hover:bg-gradient-to-bl focus:ring-4 focus:outline-none focus:ring-green-200 dark:focus:ring-green-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2">
                                Search
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            <div className="flex flex-wrap w-3/4 mt-10 mx-auto">
                {lastSixCharacterSearches.map((character, index) => (
                    <div key={character.id} className="w-1/3 px-2 mb-4">
                        <CharacterCard
                            character={character}
                        />
                    </div>
                ))}
            </div>

        </AuthenticatedLayout>
    );
}
