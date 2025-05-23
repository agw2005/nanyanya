import AppLayout from '@/layouts/app-layout';
import { type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/react';
import { useState } from 'react';

const placeholderQuiz: Quiz = {
    name: 'PyTorch Exam',
    thumbnail_url: 'https://picsum.photos/id/4/500/300',
    questions: [
        {
            question_text: 'What is 7+2',
            options: [
                {
                    label: 'A',
                    option_text: '1',
                    is_correct: false,
                },
                {
                    label: 'B',
                    option_text: '2',
                    is_correct: false,
                },
                {
                    label: 'C',
                    option_text: '9',
                    is_correct: true,
                },
                {
                    label: 'D',
                    option_text: '3',
                    is_correct: false,
                },
            ],
        },
        {
            question_text: 'What is the third letter of the alphabet?',
            options: [
                {
                    label: 'A',
                    option_text: 'Z',
                    is_correct: false,
                },
                {
                    label: 'B',
                    option_text: 'V',
                    is_correct: false,
                },
                {
                    label: 'C',
                    option_text: 'X',
                    is_correct: true,
                },
                {
                    label: 'D',
                    option_text: 'C',
                    is_correct: true,
                },
            ],
        },
        {
            question_text: 'What is the winning animal of the chinese zodiac?',
            options: [
                {
                    label: 'A',
                    option_text: 'Dragon',
                    is_correct: false,
                },
                {
                    label: 'B',
                    option_text: 'Rat',
                    is_correct: true,
                },
                {
                    label: 'C',
                    option_text: 'Chicken',
                    is_correct: false,
                },
                {
                    label: 'D',
                    option_text: 'Pig',
                    is_correct: false,
                },
            ],
        },
        {
            question_text: 'What is the first 3D animated oscard nominee?',
            options: [
                {
                    label: 'A',
                    option_text: 'Toy Story',
                    is_correct: true,
                },
                {
                    label: 'B',
                    option_text: 'Cars',
                    is_correct: false,
                },
                {
                    label: 'C',
                    option_text: 'Wall-E',
                    is_correct: false,
                },
                {
                    label: 'D',
                    option_text: 'Up',
                    is_correct: false,
                },
            ],
        },
        {
            question_text: 'Which is not a primary color?',
            options: [
                {
                    label: 'A',
                    option_text: 'Red',
                    is_correct: false,
                },
                {
                    label: 'B',
                    option_text: 'Green',
                    is_correct: false,
                },
                {
                    label: 'C',
                    option_text: 'Blue',
                    is_correct: false,
                },
                {
                    label: 'D',
                    option_text: 'Yellow',
                    is_correct: true,
                },
            ],
        },
    ],
};

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Participating in quiz : ' + placeholderQuiz.name,
        href: `/participate/${placeholderQuiz.name}`,
    },
];

type Option = {
    label: string;
    option_text: string;
    is_correct: boolean;
};

type Question = {
    question_text: string;
    options: Option[];
};

type Quiz = {
    name: string;
    thumbnail_url: string;
    questions: Question[];
};

type Props = {
    quiz: Quiz;
};

export default function Index({ quiz }: Props) {
    const questionQuantity = placeholderQuiz.questions.length;
    const [questionNumber, setQuestionNumber] = useState(0);
    const currentQuestion = placeholderQuiz.questions[questionNumber];
    const optionLetter = ['A', 'B', 'C', 'D'];
    const questions = placeholderQuiz.questions;
    const [userAnswers, setUserAnswers] = useState<number[]>(Array(questionQuantity).fill(-1));
    const [uncertainAnswers, setUncertainAnswers] = useState<boolean[]>(Array(questionQuantity).fill(false));
    let currentUserAnswer = userAnswers[questionNumber];

    const submitAnswers = () => {
        const noUnansweredQuestions = !userAnswers.some((value) => value === -1);
        const noUncertainAnswers = !uncertainAnswers.some((value) => value === true);
        if (noUnansweredQuestions || noUncertainAnswers) {
            let answerEvaluation: boolean[] = new Array(questionQuantity).fill(false);
            for (let i = 0; i < questionQuantity; i++) {
                answerEvaluation[i] = placeholderQuiz.questions[i].options[userAnswers[i]].is_correct;
            }
            console.log(answerEvaluation);
        }
    };

    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title={`${placeholderQuiz.name}`} />
            <div className="flex h-[calc(100vh-5rem)] bg-[#161617] py-3">
                {/* Sidebar */}
                <div className="mr-4 flex w-[calc(20vw)] flex-col items-center gap-4 rounded-md border-2 bg-[#0b0a0b]">
                    <div className="mt-4 text-3xl font-semibold text-white underline decoration-2">Questions</div>
                    <div className="grid w-7/8 grid-cols-5 gap-2">
                        {questions.map((_, idx) => (
                            <div
                                className={`flex aspect-square items-center justify-center rounded text-3xl font-bold select-none ${
                                    userAnswers[idx] > -1
                                        ? 'bg-green-900 text-white hover:bg-green-300 hover:text-black'
                                        : questionNumber === idx && uncertainAnswers[idx] === true
                                          ? 'bg-gradient-to-b from-yellow-900 to-blue-900 text-white hover:bg-gradient-to-b hover:from-yellow-300 hover:to-blue-300 hover:text-black'
                                          : uncertainAnswers[idx] === true
                                            ? 'bg-yellow-900 text-white hover:bg-yellow-300 hover:text-black'
                                            : questionNumber === idx
                                              ? 'bg-blue-900 text-white hover:bg-blue-300 hover:text-black'
                                              : 'bg-[#262626] text-white hover:bg-white hover:text-black'
                                } `}
                                key={idx}
                                onClick={() => {
                                    setQuestionNumber(idx);
                                }}
                            >
                                <p className="text-center">{idx + 1}</p>
                            </div>
                        ))}
                    </div>
                    <button
                        onClick={submitAnswers}
                        className="rounded-2xl bg-green-900 p-5 py-2 font-bold text-white hover:bg-blue-700 active:bg-red-900"
                    >
                        Submit answers
                    </button>
                    <div className={`${uncertainAnswers.some((value) => value == true) ? '' : 'hidden'} px-12 text-center text-white`}>
                        No questions has to be marked as uncertain to submit your answer
                    </div>
                </div>
                {/* Main Content */}
                <div className="relative flex flex-1 flex-col overflow-y-auto rounded-md border-2 bg-[#0b0a0b] p-6">
                    {/* Question */}
                    <div className="mb-4 flex items-start justify-between">
                        <div className="flex flex-1 items-center">
                            <span className="text-3xl font-bold text-white">
                                {questionNumber + 1}. {currentQuestion.question_text}
                            </span>
                        </div>
                        <div className="gap-2-500 mt-auto flex flex-col items-end select-none">
                            <label
                                className={`flex items-center gap-2 px-2 py-1 select-none ${uncertainAnswers[questionNumber] ? 'bg-yellow-800' : 'bg-yellow-300'} rounded border`}
                            >
                                <input
                                    onChange={() => {
                                        const tempUncertainAnswers = [...uncertainAnswers];
                                        if (uncertainAnswers[questionNumber] == false) {
                                            tempUncertainAnswers[questionNumber] = true;
                                            setUncertainAnswers(tempUncertainAnswers);
                                        } else {
                                            tempUncertainAnswers[questionNumber] = false;
                                            setUncertainAnswers(tempUncertainAnswers);
                                        }
                                    }}
                                    checked={uncertainAnswers[questionNumber]}
                                    type="checkbox"
                                    className="h-6 w-6 rounded border border-black accent-white select-none"
                                />
                                <span className={`font-semibold ${uncertainAnswers[questionNumber] ? 'text-white' : 'text-black'} select-none`}>
                                    <p className="select-none">Uncertain</p>
                                </span>
                            </label>
                            <div className="mt-2 flex gap-2">
                                <button //Back-button
                                    onClick={() => {
                                        questionNumber == 0 ? setQuestionNumber(questionNumber) : setQuestionNumber(questionNumber - 1);
                                    }}
                                    className="flex h-10 w-10 items-center justify-center rounded-2xl"
                                >
                                    <svg
                                        className="fill-white hover:fill-red-900 active:fill-blue-900"
                                        xmlns="http://www.w3.org/2000/svg"
                                        viewBox="0 0 448 512"
                                    >
                                        <path d="M48 416c0 8.8 7.2 16 16 16l320 0c8.8 0 16-7.2 16-16l0-320c0-8.8-7.2-16-16-16L64 80c-8.8 0-16 7.2-16 16l0 320zm16 64c-35.3 0-64-28.7-64-64L0 96C0 60.7 28.7 32 64 32l320 0c35.3 0 64 28.7 64 64l0 320c0 35.3-28.7 64-64 64L64 480zm64-224c0-6.7 2.8-13 7.7-17.6l112-104c7-6.5 17.2-8.2 25.9-4.4s14.4 12.5 14.4 22l0 208c0 9.5-5.7 18.2-14.4 22s-18.9 2.1-25.9-4.4l-112-104c-4.9-4.5-7.7-10.9-7.7-17.6z" />
                                    </svg>
                                </button>
                                <button //Previous-button
                                    onClick={() => {
                                        questionNumber >= questionQuantity - 1
                                            ? setQuestionNumber(questionNumber)
                                            : setQuestionNumber(questionNumber + 1);
                                    }}
                                    className="flex h-10 w-10 items-center justify-center rounded-2xl"
                                >
                                    <svg
                                        className="fill-white hover:fill-red-900 active:fill-blue-900"
                                        xmlns="http://www.w3.org/2000/svg"
                                        viewBox="0 0 448 512"
                                    >
                                        <path d="M400 96c0-8.8-7.2-16-16-16L64 80c-8.8 0-16 7.2-16 16l0 320c0 8.8 7.2 16 16 16l320 0c8.8 0 16-7.2 16-16l0-320zM384 32c35.3 0 64 28.7 64 64l0 320c0 35.3-28.7 64-64 64L64 480c-35.3 0-64-28.7-64-64L0 96C0 60.7 28.7 32 64 32l320 0zM320 256c0 6.7-2.8 13-7.7 17.6l-112 104c-7 6.5-17.2 8.2-25.9 4.4s-14.4-12.5-14.4-22l0-208c0-9.5 5.7-18.2 14.4-22s18.9-2.1 25.9 4.4l112 104c4.9 4.5 7.7 10.9 7.7 17.6z" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                    {/* Answers */}
                    <div className="mt-2 flex flex-col gap-3">
                        {currentQuestion.options.map((option, idx) => (
                            <div
                                key={idx}
                                className={`${userAnswers[questionNumber] == idx ? 'hover:bg-green-500 hover:text-white' : 'hover:bg-gray-700 hover:text-white'} cursor-pointer rounded border border-[#161617] px-4 py-2 text-2xl font-bold active:bg-black active:text-red-500 ${userAnswers[questionNumber] == idx ? 'bg-green-900 text-white' : 'bg-[#161617] text-white'}`}
                                onClick={() => {
                                    const tempUserAnswers = [...userAnswers];
                                    if (currentUserAnswer == idx) {
                                        currentUserAnswer = -1;
                                        tempUserAnswers[questionNumber] = -1;
                                    } else {
                                        currentUserAnswer = idx;
                                        tempUserAnswers[questionNumber] = idx;
                                    }
                                    setUserAnswers(tempUserAnswers);
                                }}
                            >
                                <p>
                                    {optionLetter[idx]}. {option.option_text}
                                </p>
                            </div>
                        ))}
                    </div>
                </div>
            </div>
        </AppLayout>
    );
}
