import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head } from '@inertiajs/react';
import CharacterCard from "@/Components/CharacterCard.jsx";

export default function Dashboard({ auth, myCharacters }) {
    console.log(myCharacters)
    return (
        <AuthenticatedLayout
            user={auth.user}
            header={<h2 className="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">My characters</h2>}>
            <Head title="Dashboard" />

            <div className="py-12">
                <div className="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div className="flex flex-wrap w-full mt-10 mx-auto">
                        {myCharacters.map((character, index) => (
                            <div key={index} className="w-1/4 px-2 mb-2">
                                <CharacterCard
                                    character={character}
                                    score={character.character_mythic_plus_score}
                                />
                            </div>
                        ))}
                    </div>
                </div>
            </div>
        </AuthenticatedLayout>
    );
}
