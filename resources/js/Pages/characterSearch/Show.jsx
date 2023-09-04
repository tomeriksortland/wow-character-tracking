import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import {Head, useForm, usePage} from '@inertiajs/react';
import CharacterCard from "@/Components/CharacterCard";

export default function Index({auth, character}) {
    return (
        <AuthenticatedLayout
            user={auth.user}
            header={<h2
                className="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Character</h2>}>
            <Head title="Character search"/>

            <div className="flex justify-center mt-10 bg-gray-100 dark:bg-gray-900">
                <div className="flex flex-wrap w-3/4 mt-10 mx-auto">
                        <div key={character.id} className="w-1/3 px-2 mb-4">
                            <CharacterCard
                                character={character}
                                score={character.character_mythic_plus_score}
                            />
                        </div>
                </div>
            </div>

        </AuthenticatedLayout>
    );
}
